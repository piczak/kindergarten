<?php

namespace App\Controller\Frontend;

use App\Component\Centile;
use App\Component\Rating;
use App\Entity\Link;
use App\Entity\Participant;
use App\Entity\Setting;
use App\Form\Frontend\ParticipantType;
use App\Form\Frontend\SurveyFlow;
use App\Services\MailerService;
use App\Services\SettingsService;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class SurveyController extends AbstractController
{
    /**
     * @var MailerService
     */
    private $mailerService;

    /**
     * @var SettingsService
     */
    private $settingsService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var Encryptor
     */
    private $encryptor;

    /**
     * @var SurveyFlow
     */
    private $surveyFlow;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @param MailerService $mailerService
     * @param SettingsService $settingsService
     * @param UrlHelper $urlHelper
     * @param Encryptor $encryptor
     */
    public function __construct(
        MailerService $mailerService,
        SettingsService $settingsService,
        UrlHelper $urlHelper,
        Encryptor $encryptor,
        SurveyFlow $surveyFlow,
        KernelInterface $kernel
    ) {
        $this->mailerService = $mailerService;

        $this->settingsService = $settingsService;

        $this->urlHelper = $urlHelper;

        $this->encryptor = $encryptor;

        $this->surveyFlow = $surveyFlow;

        $this->kernel = $kernel;
    }

    /**
     * @Route("/survey/start/{hash}", name="frontend.survey.start")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $hash = $this->encryptor->decrypt($request->get('hash'));

        $link = $this->getDoctrine()
            ->getRepository(Link::class)
            ->find($hash)
        ;

        if (!$link) {
            throw $this->createNotFoundException('Podano błędny hash');
        }

        if (
            !(
                (empty($link->getStartAt()) || $link->getStartAt()->getTimestamp() <= time())
                &&
                (empty($link->getEndAt()) || $link->getEndAt()->getTimestamp() >= time())
            )
        ) {
            throw $this->createNotFoundException('Link nie jest już aktywny');
        }

        $item = new Participant();
        $item->setKindergarten($link->getKindergarten());

        $form = $this->createForm(ParticipantType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Participant $item */
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($item);
            $em->flush();

            $updateItem = $this->getDoctrine()
                ->getRepository(Participant::class)
                ->find($item->getId())
            ;

            $updateItem->setHash($this->encryptor->encrypt($item->getId()));

            $em->persist($updateItem);
            $em->flush();

            $this->mailerService->setFrom($this->settingsService->getSetting('main.mail.from'));
            $this->mailerService->setTo($item->getEmail());
            $this->mailerService->setReplyTo($this->settingsService->getSetting('main.mail.reply'));
            $this->mailerService->setTemplate('frontend.survey.link');
            $this->mailerService->setParameters([
                'kindergartenName' => $item->getKindergarten()->getName(),
                'childFirstname' => $item->getChildFirstname(),
                'link' => $this->generateUrl('frontend.individual.start', [
                    'hash' => $updateItem->getHash()
                ], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);
            $this->mailerService->send();

            $this->addFlash('success', 'Na podany adres e-mail wysłaliśmy Ci indywidualny link do ankiety. Sprawdź pocztę.');

            return $this->redirectToRoute('frontend.index');
        }

        return $this->render('frontend/survey/start.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/survey/individual/{hash}", name="frontend.individual.start")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function surveyAction(Request $request)
    {
        $hash = $this->encryptor->decrypt($request->get('hash'));

        $survey = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($hash)
        ;

        if (!$survey) {
            throw $this->createNotFoundException('Podano błędny hash');
        }

        if ($survey->getFinishedAt()) {
            return $this->redirectToRoute('frontend.individual.summary', [
                'hash' => $survey->getHash()
            ]);
        }

        if (!$survey->getExpireAt()) {
            $now = new \DateTime();
            $now->add(new \DateInterval('P14D'));

            $survey->setExpireAt($now);

            $em = $this->getDoctrine()->getManager();
            $em->persist($survey);
            $em->flush();
        }

        if (!($survey->getExpireAt() && $survey->getExpireAt()->getTimestamp() >= time())) {
            throw $this->createNotFoundException('Podano błędny hash');
        }

        $flow = $this->surveyFlow;
        $flow->bind($survey);

        $form = $flow->createForm();
        if ($flow->isValid($form)) {
            $flow->saveCurrentStepData($form);

            if ($flow->nextStep()) {
                // form for the next step
                $form = $flow->createForm();

                $survey->setCurrentStep($flow->getCurrentStepNumber());

                $em = $this->getDoctrine()->getManager();
                $em->persist($survey);
                $em->flush();
            } else {
                $survey->setCurrentStep($flow->getCurrentStepNumber());
                $survey->setFinishedAt(new \DateTime());

                // flow finished
                $em = $this->getDoctrine()->getManager();
                $em->persist($survey);
                $em->flush();

                $flow->reset();

                return $this->redirectToRoute('frontend.individual.summary', [
                    'hash' => $survey->getHash()
                ]);
            }
        }

        return $this->render('frontend/survey/individual.html.twig', [
            'form' => $form->createView(),
            'flow' => $flow,
        ]);
    }

    /**
     * @Route("/survey/summary/{hash}", name="frontend.individual.summary")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function summaryAction(Request $request)
    {
        $hash = $this->encryptor->decrypt($request->get('hash'));

        $survey = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($hash)
        ;
        
        $rating = new Rating();
        $centile = new Centile();

        if ($survey->getWeightBodymass() && $survey->getWeightHeight()) {
            $centile->setExamAt(new \DateTime());
            $centile->setBirthdayAt($survey->getBirthAt());
            $centile->setWeight($survey->getWeightBodymass());
            $centile->setHeight($survey->getWeightHeight());
            $centile->setSex($survey->getGender());

            $survey->setWeightBmi($centile->getBmi());
            $survey->setWeightBmiCentile($centile->getBmiCentile());
        }

        if ($survey->getFitnessStand()) {
            $survey->setStandRating($rating->get_fitness_stand_rating($survey->getCurrentAge(), $survey->getGender(), $survey->getFitnessStand()));
        }

        if ($survey->getFitnessAlternRun()) {
            $survey->setAlternRunRating($rating->get_fitness_altern_run_rating($survey->getCurrentAge(), $survey->getGender(), $survey->getFitnessAlternRun()));
        }

        if ($survey->getFitnessJump()) {
            $survey->setJumpRating($rating->get_fitness_jump_rating($survey->getCurrentAge(), $survey->getGender(), $survey->getFitnessJump()));
        }

        if ($survey->getFitnessRun20()) {
            $survey->setRun20Rating($rating->get_fitness_run20_rating($survey->getCurrentAge(), $survey->getGender(), $survey->getFitnessRun20()));
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($survey);
        $em->flush();
        
        if ($survey->getStatusFood()) {
            $survey->setStatusFood($survey->getStatusFood());
        }

        if ($survey->getStatusNicotine()) {
            $survey->setStatusNicotine($survey->getStatusNicotine());
        }

        if ($survey->getStatusImmune()) {
            $survey->setStatusImmune($survey->getStatusImmune());
        }

        if ($survey->getStatusSleep()) {
            $survey->setStatusSleep($survey->getStatusSleep());
        }

        if ($survey->getStatusDigital()) {
            $survey->setStatusDigital($survey->getStatusDigital());
        }

        if ($survey->getStatusAdaptation()) {
            $survey->setStatusAdaptation($survey->getStatusAdaptation());
        }

        if ($survey->getStatusExternal()) {
            $survey->setStatusExternal($survey->getStatusExternal());
        }

        if ($survey->getStatusNewness()) {
            $survey->setStatusNewness($survey->getStatusNewness());
        }

        if ($survey->getStatusFocus()) {
            $survey->setStatusFocus($survey->getStatusFocus());
        }

        if ($survey->getStatusWeight()) {
            $survey->setStatusWeight($survey->getStatusWeight());
        }

        if ($survey->getStatusActivity()) {
            $survey->setStatusActivity($survey->getStatusActivity());
        }

        if ($survey->getStatusFitness()) {
            $survey->setStatusFitness($survey->getStatusFitness());
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($survey);
        $em->flush();
        
        $sett = $this->settingsService;

        if (!$survey) {
            throw $this->createNotFoundException('Podano błędny hash');
        }

        return $this->render('frontend/survey/summary.html.twig', [
            'survey' => $survey,
            'sett' => $sett
        ]);
    }

    /**
     * @Route("/survey/pdf/{hash}", name="frontend.individual.pdf")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pdfAction(Request $request, \Knp\Snappy\Pdf $knpSnappyPdf)
    {
        $hash = $this->encryptor->decrypt($request->get('hash'));

        $survey = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($hash)
        ;
        
        $sett = $this->settingsService;

        if (!$survey) {
            throw $this->createNotFoundException('Podano błędny hash');
        }

        $content = $this->renderView('frontend/survey/pdf.html.twig', [
            'survey' => $survey,
            'sett' => $sett
        ]);
        
        $firstname = $survey->getChildFirstname();
        $firstnameAscii = iconv('UTF-8', 'ASCII//TRANSLIT', $firstname);

        return new PdfResponse(
            $knpSnappyPdf->getOutputFromHtml($content),
            $firstnameAscii . '_' . date('Ymd') . '.pdf'
        );
    }
}

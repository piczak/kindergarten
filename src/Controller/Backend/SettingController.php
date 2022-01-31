<?php

namespace App\Controller\Backend;

use App\Entity\Setting;
use App\Form\Backend\SettingsType;
use App\Services\SettingsService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SettingController
 * @package App\Controller\Backend
 */
class SettingController extends AbstractController
{
    /**
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * SettingsController constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/settings/{section}", name="admin.settings")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Setting::class)
            ->findBySection($request->get('section', 1))
        ;

        $form = $this->createForm(SettingsType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->settingsService->updateSettings($request->request->get('settings'));

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.settings', [
                'section' => $request->get('section')
            ]);
        }

        return $this->render('backend/settings/index.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }
}

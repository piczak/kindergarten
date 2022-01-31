<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\ParticipantTableType;
use App\Entity\Participant;
use League\Csv\Writer;
use League\Csv\ByteSequence;
use App\Form\Backend\ParticipantType;
use App\Form\Backend\SchoolType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ParticipantController
 * @package App\Controller\Backend
 */
class ParticipantController extends AbstractController
{
    /**
     * @var DataTableFactory
     */
    protected $dataTable;

    /**
     * ParticipantController constructor.
     * @param DataTableFactory $dataTable
     */
    public function __construct(DataTableFactory $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/participants", name="admin.participants")
     * @Route("/admin/participants", name="admin.participants.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $table = $this
            ->dataTable
            ->createFromType(ParticipantTableType::class)
            ->handleRequest($request)
        ;

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/participants/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/participants/edit/{id}", name="admin.participants.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $form = $this->createForm(ParticipantType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.participants');
        }

        return $this->render('backend/participants/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/participants/delete/{id}", name="admin.participants.delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Usunięcie przebiegło pomyślnie');

        return $this->redirectToRoute('admin.participants');
    }
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/participants/report", name="admin.participants.report")
     * @param Request $request
     * @return Response
     */
    public function raportAction(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->getParticipantsForReport()
        ;

        $csv = Writer::createFromString('');
        $csv->setNewline("\r\n");
        $csv->setOutputBOM(ByteSequence::BOM_UTF8);
        //$csv->setEnclosure(' ');
        $csv->setDelimiter(';');

        $csv->insertOne(array_keys($items[0]));
        
        $records = [];
        foreach ($items as $it) {
            $records[] = array_values($it);
        }

        $csv->insertAll($records);

        $response = new Response();

        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'application/octet-stream');
        $response->headers->set('Content-Disposition', 'attachment; filename="zdrowyprzedszkolak_' . date('Y-m-d_H.i') . '.csv";');
        $response->headers->set('Content-length', strlen($csv->getContent()));

        $response->sendHeaders();

        $response->setContent($csv->getContent());

        return $response;
    }
}

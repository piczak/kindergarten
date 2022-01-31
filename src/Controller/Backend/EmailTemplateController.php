<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\EmailTemplateTableType;
use App\Entity\EmailTemplate;
use App\Form\Backend\EmailTemplateType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EmailTemplateController
 * @package App\Controller\Backend
 */
class EmailTemplateController extends AbstractController
{
    /**
     * @var DataTableFactory
     */
    protected $dataTable;

    /**
     * EmailTemplateController constructor.
     * @param DataTableFactory $dataTable
     */
    public function __construct(DataTableFactory $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/emails", name="admin.emails")
     * @Route("/admin/emails", name="admin.emails.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $table = $this
            ->dataTable
            ->createFromType(EmailTemplateTableType::class)
            ->handleRequest($request)
        ;

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/emails/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/emails/edit/{id}", name="admin.emails.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(EmailTemplate::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $form = $this->createForm(EmailTemplateType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.emails');
        }

        return $this->render('backend/emails/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }
}

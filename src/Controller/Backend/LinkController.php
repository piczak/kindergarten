<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\LinkTableType;
use App\Entity\Link;
use App\Form\Backend\LinkType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @var DataTableFactory
     */
    protected $dataTable;

    /**
     * RedirectController constructor.
     * @param DataTableFactory $dataTable
     */
    public function __construct(DataTableFactory $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/links", name="admin.links")
     * @Route("/admin/links", name="admin.links.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $table = $this
            ->dataTable
            ->createFromType(LinkTableType::class)
            ->handleRequest($request)
        ;

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/links/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/links/add", name="admin.links.add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $item = new Link();

        $form = $this->createForm(LinkType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Dodanie przebiegło pomyślnie');

            return $this->redirectToRoute('admin.links');
        }

        return $this->render('backend/links/add.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/links/edit/{id}", name="admin.links.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Link::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $form = $this->createForm(LinkType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.links');
        }

        return $this->render('backend/links/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_EDITOR")
     * @Route("/admin/links/delete/{id}", name="admin.links.delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Link::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Usunięcie przebiegło pomyślnie');

        return $this->redirectToRoute('admin.links');
    }
}

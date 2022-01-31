<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\RedirectTableType;
use App\Entity\Redirect;
use App\Enum\RedirectStatus;
use App\Form\Backend\RedirectType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RedirectController
 * @package App\Controller\Backend
 */
class RedirectController extends AbstractController
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
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/redirects", name="admin.redirects")
     * @Route("/admin/redirects", name="admin.redirects.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $table = $this
            ->dataTable
            ->createFromType(RedirectTableType::class)
            ->handleRequest($request)
        ;

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/redirects/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/redirects/add", name="admin.redirects.add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $item = new Redirect();

        $form = $this->createForm(RedirectType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Dodanie przebiegło pomyślnie');

            return $this->redirectToRoute('admin.redirects');
        }

        return $this->render('backend/redirects/add.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/redirects/edit/{id}", name="admin.redirects.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Redirect::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $form = $this->createForm(RedirectType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.redirects');
        }

        return $this->render('backend/redirects/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/redirects/status/{id}/{status}", name="admin.redirects.status")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function statusAction(Request $request)
    {
        $mapping = [
            'allowed' => [RedirectStatus::ACTIVE, RedirectStatus::INACTIVE],
            'mapping' => [
                RedirectStatus::ACTIVE => [
                    'href' => $this->generateUrl('admin.redirects.status', [
                        'id' => $request->get('id'),
                        'status' => RedirectStatus::INACTIVE
                    ]),
                    'hrefClass'=> 'btn btn-xs btn-success',
                    'class' => 'fa fa-check'
                ],
                RedirectStatus::INACTIVE => [
                    'href' => $this->generateUrl('admin.redirects.status', [
                        'id' => $request->get('id'),
                        'status' => RedirectStatus::ACTIVE
                    ]),
                    'hrefClass'=> 'btn btn-xs btn-danger',
                    'class' => 'fa fa-times',
                ]
            ]
        ];

        $item = $this->getDoctrine()
            ->getRepository(Redirect::class)
            ->find($request->get('id'));

        $result = [
            'status' => 'error'
        ];

        if ($item) {
            $newStatus = $request->get('status');

            $item->setIsActive($newStatus);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $result = [
                'status' => 'success',
                'href' => $mapping['mapping'][$newStatus]['href'],
                'hrefClass' => $mapping['mapping'][$newStatus]['hrefClass'],
                'class' => $mapping['mapping'][$newStatus]['class']
            ];
        }

        if ($request->isXmlHttpRequest()) {
            return $this->json($result);
        }

        return $this->redirectToRoute('admin.redirects');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/redirects/delete/{id}", name="admin.redirects.delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(Redirect::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Usunięcie przebiegło pomyślnie');

        return $this->redirectToRoute('admin.redirects');
    }
}

<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\AdminTableType;
use App\Entity\User;
use App\Form\Backend\AdminEditType;
use App\Form\Backend\AdminType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminsController
 * @package App\Controller\Backend
 */
class AdminController extends AbstractController
{
    /**
     * @var DataTableFactory
     */
    protected $dataTable;

    /**
     * AdminsController constructor.
     * @param DataTableFactory $dataTable
     */
    public function __construct(DataTableFactory $dataTable)
    {
        $this->dataTable = $dataTable;

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/admins", name="admin.admins")
     * @Route("/admin/admins", name="admin.admins.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $table = $this
            ->dataTable
            ->createFromType(AdminTableType::class)
            ->handleRequest($request)
        ;

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('backend/admins/index.html.twig', [
            'datatable' => $table
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/admins/add", name="admin.admins.add")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $item = new User();
        $item->setIsEnabled(true);

        $form = $this->createForm(AdminType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $item->setUsername($form->get('email')->getData());

            $encodedPassword = $userPasswordEncoder->encodePassword(
                $this->getUser(),
                $form->get('plainPassword')->getData()
            );

            $item->setPassword($encodedPassword);
            $item->setRoles([$form->get('roles')->getData()]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Dodanie przebiegło pomyślnie');

            return $this->redirectToRoute('admin.admins');
        }

        return $this->render('backend/admins/add.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/admins/edit/{id}", name="admin.admins.edit")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $form = $this->createForm(AdminEditType::class, $item);
        $form->handleRequest($request);

        if (in_array('ROLE_EDITOR', $item->getRoles())) {
            $form->get('roles')->setData('ROLE_EDITOR');
        } else {
            $form->get('roles')->setData('ROLE_ADMIN');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $item->setUsername($form->get('email')->getData());
            $item->setRoles([$form->get('roles')->getData()]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.admins');
        }

        return $this->render('backend/admins/edit.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/admins/delete/{id}", name="admin.admins.delete")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $item = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($request->get('id'))
        ;

        if (!$item) {
            throw $this->createNotFoundException('Nie znaleziono obiektu');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        $this->addFlash('success', 'Usunięcie przebiegło pomyślnie');

        return $this->redirectToRoute('admin.admins');
    }
}

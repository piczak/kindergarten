<?php

namespace App\Controller\Backend;

use App\Form\Backend\PasswordChangeType;
use App\Form\Backend\ProfileChangeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ProfileController
 * @package App\Controller\Backend
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/admin/profile/change-profile", name="admin.profile.profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $item = $this->getUser();

        $form = $this->createForm(ProfileChangeType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.profile.profile');
        }

        return $this->render('backend/profile/profile.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/profile/change-password", name="admin.profile.password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function passwordAction(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $item = $this->getUser();

        $form = $this->createForm(PasswordChangeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $userPasswordEncoder->encodePassword(
                $this->getUser(),
                $form->get('plainPassword')->getData()
            );

            $item->setPassword($encodedPassword);

            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            $this->addFlash('success', 'Edycja przebiegła pomyślnie');

            return $this->redirectToRoute('admin.profile.password');
        }

        return $this->render('backend/profile/password.html.twig', [
            'item' => $item,
            'form' => $form->createView()
        ]);
    }
}

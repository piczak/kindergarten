<?php

namespace App\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdminType
 * @package App\Form\Backend
 */
class AdminType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'Rola',
                'choices' => [
                    'Administrator' => 'ROLE_ADMIN',
                    'Koordynator' => 'ROLE_EDITOR'
                ],
                'mapped' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'E-mail'
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Imię'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nazwisko'
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => [
                    'label' => 'Hasło'
                ],
                'second_options' => [
                    'label' => 'Powtórz hasło'
                ],
                'invalid_message' => 'Podane hasłą powinny być takie same',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'messages_backend'
        ]);
    }
}

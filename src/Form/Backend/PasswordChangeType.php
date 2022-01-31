<?php

namespace App\Form\Backend;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class PasswordChangeType
 * @package App\Form\Backend
 */
class PasswordChangeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $constraintsOptions = [
            'message' => 'Podane hasło jest błędne',
        ];

        if (!empty($options['validation_groups'])) {
            $constraintsOptions['groups'] = [
                reset($options['validation_groups'])
            ];
        }

        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Aktualne hasło',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new UserPassword($constraintsOptions),
                ],
                'attr' => [
                    'autocomplete' => 'current-password',
                ],
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

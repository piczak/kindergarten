<?php

namespace App\Form\Backend;

use App\Entity\Kindergarten;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LinkType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kindergarten', EntityType::class, [
                'required' => false,
                'label' => 'Przedszkole',
                'class' => Kindergarten::class,
                'choice_label' => 'name',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole jest wymagane',
                    ]),
                ]
            ])
            ->add('startAt', TextType::class, [
                'required' => false,
                'label' => 'Data od',
            ])
            ->add('endAt', TextType::class, [
                'required' => false,
                'label' => 'Data do',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;


        $builder->get('startAt')
            ->addModelTransformer(new CallbackTransformer(
                function (?\DateTime $date) {
                    //Z bazy
                    return $date ? $date->format('Y-m-d') : '';
                },
                function (?string $date) {
                    //Do bazy
                    return $date ? \DateTime::createFromFormat('Y-m-d', $date) : null;
                }
            ))
        ;

        $builder->get('endAt')
            ->addModelTransformer(new CallbackTransformer(
                function (?\DateTime $date) {
                    //Z bazy
                    return $date ? $date->format('Y-m-d') : '';
                },
                function (?string $date) {
                    //Do bazy
                    return $date ? \DateTime::createFromFormat('Y-m-d', $date) : null;
                }
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation_domain' => 'messages'
        ]);
    }
}

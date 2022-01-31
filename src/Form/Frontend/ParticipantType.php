<?php

namespace App\Form\Frontend;

use App\Enum\GenderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ParticipantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'E-mail rodzica/opiekuna*',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole jest wymagane',
                    ]),
                    new Email([
                        'message' => 'Podaj poprawny adres e-mail'
                    ])
                ]
            ])
            ->add('childFirstname', TextType::class, [
                'required' => false,
                'label' => 'Imię dziecka*',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole jest wymagane',
                    ]),
                ]
            ])
            ->add('birthAt', TextType::class, [
                'required' => false,
                'label' => 'Data urodzenia dziecka*',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole jest wymagane',
                    ]),
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'required' => false,
                'label' => 'Płeć dziecka*',
                'choices' => [
                    'Kobieta' => GenderType::FEMALE,
                    'Mężczyzna' => GenderType::MALE
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole jest wymagane',
                    ]),
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;

        //Trasformery
        $builder->get('birthAt')
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

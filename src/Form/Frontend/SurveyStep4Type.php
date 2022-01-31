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

class SurveyStep4Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//52
            ->add('emotionsEmbarrass', ChoiceType::class, [
                'label' => 'Czy dziecko w obecności nowych osób okazuje zakłopotanie?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//53
            ->add('emotionsNewplace', ChoiceType::class, [
                'label' => 'Czy dziecko szybko przyzwyczaja się do nowego miejsca?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//54
            ->add('emotionsNewperson', ChoiceType::class, [
                'label' => 'Czy gdy dziecko kogoś nie zna – powoli przekonuje się do nowej osoby?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//55
            ->add('emotionsChanges', ChoiceType::class, [
                'label' => 'Czy dziecko lubi zmiany?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//56
            ->add('emotionsLost', ChoiceType::class, [
                'label' => 'Czy dziecko jest zagubione w nowych warunkach?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//57
            ->add('emotionsNewguardian', ChoiceType::class, [
                'label' => 'Czy dziecko szybko przyzwyczaja się do nowych opiekunów?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//58
            ->add('emotionsNotself', ChoiceType::class, [
                'label' => 'Czy dziecko w nowym miejscu długo nie jest sobą?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//59
            ->add('emotionsKindergarten', ChoiceType::class, [
                'label' => 'Czy dziecko szybko przyzwyczaja/przyzwyczaiło się do żłobka/przedszkola?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//60
            ->add('emotionsCompletion', ChoiceType::class, [
                'label' => 'Czy dziecko prawie zawsze doprowadza to co robi do końca?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//61
            ->add('emotionsOnetoy', ChoiceType::class, [
                'label' => 'Czy dziecko umie bawić się długo w skupieniu jedną zabawką?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//62
            ->add('emotionsDin', ChoiceType::class, [
                'label' => 'Czy dziecko bez trudu może się skupić mimo tego, że wokół jest szum czy rozgardiasz?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//63
            ->add('emotionsPerseverance', ChoiceType::class, [
                'label' => 'Czy dziecko, gdy robi coś nowego, jest wytrwałe?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//64
            ->add('emotionsTrying', ChoiceType::class, [
                'label' => 'Czy dziecko, gdy mu coś nie wychodzi, próbuje, aż do skutku?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//65
            ->add('emotionsDiscourage', ChoiceType::class, [
                'label' => 'Czy dziecko łatwo zraża się niepowodzeniami?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//66
            ->add('emotionsFocus', ChoiceType::class, [
                'label' => 'Czy dziecko może długo w skupieniu coś robić?',
                'choices' => [
                    'Nie' => '1',
                    'Tak' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
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

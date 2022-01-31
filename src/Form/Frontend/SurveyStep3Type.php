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

class SurveyStep3Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //37
            ->add('socialIdeas', ChoiceType::class, [
                'label' => 'Czy dziecko ma swoje pomysły w różnych sytuacjach?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//38
            ->add('socialNew', ChoiceType::class, [
                'label' => 'Czy dziecko szybko oswaja się z nowymi sytuacjami?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//39
            ->add('socialEquals', ChoiceType::class, [
                'label' => 'Czy dziecko łatwo nawiązuje kontakty z rówieśnikami?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//40
            ->add('socialExpress', ChoiceType::class, [
                'label' => 'Czy dziecko potrafi wyrażać swoje upodobania?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//41
            ->add('socialCurious', ChoiceType::class, [
                'label' => 'Czy dziecko jest otwarte i ciekawe tego, co dzieje się wokół?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//42
            ->add('socialNeeds', ChoiceType::class, [
                'label' => 'Czy dziecko potrafi powiedzieć albo pokazać, czego potrzebuje?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//43
            ->add('socialHelp', ChoiceType::class, [
                'label' => 'Czy dziecko spontanicznie zwraca się o pomoc do dorosłego?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//44
            ->add('socialCreative', ChoiceType::class, [
                'label' => 'Czy widać, że dziecko jest twórcze w tym, co robi, ma swoje pomysły?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//45
            ->add('socialAgression', ChoiceType::class, [
                'label' => 'Czy w kontaktach dziecka z dorosłymi jest sporo złości i agresji?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//46
            ->add('socialThrow', ChoiceType::class, [
                'label' => 'Czy zdarza się, że dziecko rzuca zabawkami, gdy mu się czegoś odmówi?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//47
            ->add('socialScream', ChoiceType::class, [
                'label' => 'Czy dziecko krzyczy albo tupie, gdy mu się coś nie podoba?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//48
            ->add('socialAngry', ChoiceType::class, [
                'label' => 'Czy dziecko złości się, gdy jest z czegoś niezadowolone?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//49
            ->add('socialResist', ChoiceType::class, [
                'label' => 'Czy dziecko stawia silny opór, gdy mu się coś nie podoba?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//50
            ->add('socialUnpatient', ChoiceType::class, [
                'label' => 'Czy dziecko szybko się niecierpliwi i denerwuje?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//51
            ->add('socialDischarge', ChoiceType::class, [
                'label' => 'Czy dziecko wyładowuje swoją złość na zabawkach albo innych przedmiotach?',
                'choices' => [
                    'Nigdy' => '1',
                    'Czasem' => '2',
                    'Często' => '3',
                    'Zawsze' => '4'
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

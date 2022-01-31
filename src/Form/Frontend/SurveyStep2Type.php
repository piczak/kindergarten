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

class SurveyStep2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //21
            ->add('nicotineEnvironment', ChoiceType::class, [
                'label' => 'Czy w bezpośrednim otoczeniu dziecka są osoby palące tytoń lub używające “e-papierosów” lub podgrzewaczy tytoniu?',
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
//22
            ->add('nicotineHome', ChoiceType::class, [
                'label' => 'Czy w domu/mieszkaniu, w którym przebywa dziecko ktoś pali tytoń lub używa e- papierosów lub podgrzewaczy tytoniu?',
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
//23
            ->add('immuneCorrect', ChoiceType::class, [
                'label' => 'Czy dziecko jest szczepione zgodnie z aktualnym kalendarzem szczepień ochronnych?',
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
//24
            ->add('sleepProblems', ChoiceType::class, [
                'label' => 'Czy dziecko ma problemy z chodzeniem spać lub z zasypianiem?',
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
//25
            ->add('sleepTired', ChoiceType::class, [
                'label' => 'Czy dziecko często wydaje się przemęczone lub senne w ciągu dnia?',
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
//26
            ->add('sleepNapping', ChoiceType::class, [
                'label' => 'Czy dziecko wciąż wymaga drzemek?',
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
//27
            ->add('sleepAwakening', ChoiceType::class, [
                'label' => 'Czy dziecko często budzi się w nocy?',
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
//28
            ->add('sleepDuration', ChoiceType::class, [
                'label' => 'Czy dziecko śpi od 10 do 13 godzin dziennie?',
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
//29
            ->add('sleepBreathe', ChoiceType::class, [
                'label' => 'Czy dziecko chrapie lub ma trudności z oddychaniem podczas snu?',
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
//30
            ->add('digitalUsing', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko korzysta z tabletu lub smartfona?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//31
            ->add('digitalInternet', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko używa internetu bez Twojej kontroli?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//32
            ->add('digitalGames', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko gra w gry komputerowe, gry na konsolę, na tablecie i smartfonie?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//33
            ->add('digitalDisturb', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko używa smartfona, tabletu lub innego urządzenia dlatego, abyś mógł zająć się innymi sprawami?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//34
            ->add('digitalRewarding', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko jest nagradzane poprzez zwiększenie dostępu do internetu lub możliwością korzystania z urządzeń ekranowych (smartfona, tabletu komputera) w większym zakresie czasowym?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//35
            ->add('digitalTime', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko traci kontrolę nad czasem używania smartfona, tabletu, komputera, konsoli?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//36
            ->add('digitalBored', ChoiceType::class, [
                'label' => 'Czy Twoje dziecko gdy się nudzi, samodzielnie sięga po urządzenia ekranowe (smartfon, tablet, komputer) lub gry komputerowe?',
                'choices' => [
                    'Często' => '1',
                    'Sporadycznie' => '2',
                    'Nigdy' => '3'
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

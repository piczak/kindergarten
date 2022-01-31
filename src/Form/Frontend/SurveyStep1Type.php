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

class SurveyStep1Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //1
            ->add('foodBreakfast', ChoiceType::class, [
                'label' => 'Podaję mojemu dziecku śniadanie przed wyjściem do przedszkola',
                'choices' => [
                    'Zawsze' => '1',
                    'Zazwyczaj' => '2',
                    'Czasami' => '3',
                    'Rzadko' => '4',
                    'Nigdy' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//2
            ->add('foodDinner', ChoiceType::class, [
                'label' => 'Podaję mojemu dziecku obiad po prowrocie z przedszkola',
                'choices' => [
                    'Zawsze' => '1',
                    'Zazwyczaj' => '2',
                    'Czasami' => '3',
                    'Rzadko' => '4',
                    'Nigdy' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//3
            ->add('foodGrain', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle zjada produkty zbożowe',
                'choices' => [
                    'Więcej niż 5 razy dziennie' => '1',
                    '4 do 5 razy dziennie' => '2',
                    '2 do 3 razy dziennie' => '3',
                    'Mniej niż 2 razy dziennie' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//4
            ->add('foodDiary', ChoiceType::class, [
                'label' => 'Moje dziecko zjada zwykle produkty mleczne',
                'choices' => [
                    'Więcej niż 3 razy dziennie' => '1',
                    '3 razy dziennie' => '2',
                    '2 razy dziennie' => '3',
                    'Raz dziennie lub mniej' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//5
            ->add('foodFruits', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle je owoce',
                'choices' => [
                    'Więcej niż 3 razy dziennie' => '1',
                    '3 razy dziennie' => '2',
                    '2 razy dziennie' => '3',
                    'Raz dziennie' => '4',
                    'Wcale' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//6
            ->add('foodVegetables', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle je warzywa',
                'choices' => [
                    'Więcej niż 2 razy dziennie' => '1',
                    '2 razy dziennie' => '2',
                    'Raz dziennie' => '3',
                    'Wcale' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//7
            ->add('foodMeat', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle je mięso, ryby, drób',
                'choices' => [
                    'Więcej niż 2 razy dziennie' => '1',
                    '2 razy dziennie' => '2',
                    'Raz dziennie' => '3',
                    'Kilka razy w tygodniu' => '4',
                    'Wcale' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//8
            ->add('foodFastfood', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle je żywność typu „fast food”',
                'choices' => [
                    '4 lub więcej razy w tygodniu' => '1',
                    '2 do 3 razy w tygodniu' => '2',
                    'Raz w tygodniu' => '3',
                    'Kilka razy w miesiącu' => '4',
                    'Raz w miesiącu lub mniej' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//9
            ->add('foodBuying', ChoiceType::class, [
                'label' => 'Jako rodzic mam trudności z zakupem żywności do karmienia mojego dziecka, ponieważ jedzenie jest drogie',
                'choices' => [
                    'Zdarza się tak w większości przypadków' => '1',
                    'Zdarza się tak czasami' => '2',
                    'Zdarza się tak rzadko' => '3',
                    'Nie mam takiego problemu' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//10
            ->add('foodChewing', ChoiceType::class, [
                'label' => 'Moje dziecko ma problemy z żuciem, połykaniem, wymiotowaniem lub dławieniem/zadławianiem podczas jedzenia',
                'choices' => [
                    'Zdarza się tak w większości przypadków' => '1',
                    'Zdarza się tak czasami' => '2',
                    'Zdarza się tak rzadko' => '3',
                    'Nie mam takiego problemu' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//11
            ->add('foodDrinking', ChoiceType::class, [
                'label' => 'Moje dziecko nie jest głodne w czasie posiłków, ponieważ przez cały dzień coś pije',
                'choices' => [
                    'Zdarza się tak w większości przypadków' => '1',
                    'Zdarza się tak czasami' => '2',
                    'Zdarza się tak rzadko' => '3',
                    'Nie mam takiego problemu' => '4'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//12
            ->add('foodEating', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle je',
                'choices' => [
                    'Mniej niż 2 razy dziennie' => '1',
                    '2 razy dziennie' => '2',
                    '3 do 4 razy dziennie' => '3',
                    '5 razy dziennie' => '4',
                    'Więcej niż 5 razy dziennie' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//13
            ->add('foodAllowing', ChoiceType::class, [
                'label' => 'Pozwalam dziecku decydować, ile chce zjeść',
                'choices' => [
                    'Zawsze' => '1',
                    'Zazwyczaj' => '2',
                    'Czasami' => '3',
                    'Rzadko' => '4',
                    'Nigdy' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//14
            ->add('foodTv', ChoiceType::class, [
                'label' => 'Moje dziecko je posiłki podczas oglądania telewizji',
                'choices' => [
                    'Zawsze' => '1',
                    'Zazwyczaj' => '2',
                    'Czasami' => '3',
                    'Rzadko' => '4',
                    'Nigdy' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//15
            ->add('foodSupplements', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle przyjmuje suplementy',
                'choices' => [
                    'Zawsze' => '1',
                    'Zazwyczaj' => '2',
                    'Czasami' => '3',
                    'Rzadko' => '4',
                    'Nigdy' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//16
            ->add('foodFeeding', ChoiceType::class, [
                'label' => 'Moje dziecko w okresie niemowlęcym karmione było w sposób:',
                'choices' => [
                    'naturalny - mleko z piersi' => '1',
                    'sztuczny - mleko modyfikowane' => '2',
                    'mieszany' => '3'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//17
            ->add('foodActivity', ChoiceType::class, [
                'label' => 'Moje dziecko',
                'choices' => [
                    'Potrzebuje więcej aktywności fizycznej' => '1',
                    'Ma wystarczająco aktywności fizycznej' => '2'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//18
            ->add('foodTvGames', ChoiceType::class, [
                'label' => 'Moje dziecko zwykle ogląda telewizję, korzysta z komputera i gra w gry wideo',
                'choices' => [
                    '5 lub więcej godzin dziennie' => '1',
                    '4 godziny dziennie' => '2',
                    '3 godziny dziennie' => '3',
                    '2 godziny dziennie' => '4',
                    '1 godzina lub mniej dziennie' => '5'
                ],
                'expanded' => true,
                'multiple' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                ],
            ])
//19
            ->add('foodDevelopment', ChoiceType::class, [
                'label' => 'Jestem zadowolony z tego jak rozwija się moje dziecko',
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
//20
            ->add('foodWeight', ChoiceType::class, [
                'label' => 'Moje dziecko',
                'choices' => [
                    'Powinno ważyć więcej' => '1',
                    'Ma odpowiednią masę ciała' => '2',
                    'Powinno ważyć mniej' => '3'
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

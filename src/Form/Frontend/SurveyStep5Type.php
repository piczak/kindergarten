<?php

namespace App\Form\Frontend;

use App\Enum\GenderType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class SurveyStep5Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //67
            ->add('weightBodymass', NumberType::class, [
                'label' => 'Podaj masę ciała (tzw. "wagę") dziecka w kilogramach',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
                ],
            ])
//68
            ->add('weightHeight', NumberType::class, [
                'label' => 'Podaj wysokość ciała (tzw. "wzrost") dziecka w centymetrach',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
                ],
            ])
//69
            ->add('activityWeek', ChoiceType::class, [
                'label' => 'Czy w czasie typowego tygodnia ma u dziecka miejsce wysiłek fizyczny dający wyraźne sygnały zmęczenia?',
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
//70
            ->add('activity3days', ChoiceType::class, [
                'label' => 'Czy powyższy wysiłek ma miejsce w co najmniej 3 różnych dniach typowego tygodnia?',
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
//71
            ->add('activity10minutes', ChoiceType::class, [
                'label' => 'Czy powyższy wysiłek trwa za każdym razem co najmniej 10 minut bez przerwy?',
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
//72
            ->add('fitnessJump', NumberType::class, [
                'label' => 'Wynik skoku w dal z miejsca z odbicia obunóż (centymetry)',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
                ],
            ])
//73
            ->add('fitnessAlternRun', NumberType::class, [
                'label' => 'Wynik biegu wahadłowego 4 x 10m (sekundy)',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
                ],
            ])
//74
            ->add('fitnessStand', NumberType::class, [
                'label' => 'Wynik testu postawy na jednej nodze (sekundy)',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
                ],
            ])
//75
            ->add('fitnessRun20', NumberType::class, [
                'label' => 'Wynik biegu na 20 metrów ze startu wysokiego (sekundy)',
                'scale' => 2,
                'input' => 'string',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Odpowiedź na to pytnie jest wymagana'
                    ]),
                    new Positive([
                        'message' => 'Podaj liczbę dodatnią'
                    ])
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

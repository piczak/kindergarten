<?php

namespace App\Form\Backend;

use App\Entity\Commune;
use App\Entity\County;
use App\Entity\School;
use App\Entity\Street;
use App\Entity\Town;
use App\Entity\Voivodeship;
use App\Enum\GenderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ParticipantType
 * @package App\Form\Backend
 */
class ParticipantType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ParticipantType constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expireAt', TextType::class, [
                'required' => false,
                'label' => 'Data wygaśnięcia',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;

        $builder->get('expireAt')
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

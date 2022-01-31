<?php

namespace App\Form\Backend;

use App\Enum\SettingsType as SettingsTypeEnum;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SettingsType
 * @package App\Form\Backend
 */
class SettingsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();
            $form = $event->getForm();

            foreach ($entity as $it) {
                if ($it['type'] == SettingsTypeEnum::TEXT) {
                    $this->buildTextField($form, $it);
                } else if ($it['type'] == SettingsTypeEnum::TEXTAREA) {
                    $this->buildTextareaField($form, $it);
                } else if ($it['type'] == SettingsTypeEnum::CHOICE) {
                    $this->buildChoiceField($form, $it);
                } else if ($it['type'] == SettingsTypeEnum::EDITOR) {
                    $this->buildEditorField($form, $it);
                }
            }

            $form
                ->add('submit', SubmitType::class, [
                    'label' => 'Zapisz',
                    'attr' => [
                        'class' => 'btn btn-primary'
                    ]
                ])
            ;
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mapped' => false,
            'translation_domain' => 'messages_backend'
        ]);
    }

    /**
     * Zbudowanie pola tekstowego
     * @param $form
     * @param $it
     */
    protected function buildTextField(&$form, $it)
    {
        $form
            ->add($this->getNormalizedFormHash($it['hash']), TextType::class, [
                'label' => $it['name'],
                'data' => $it['value'],
                'help' => $it['description'],
                'required' => false,
                'mapped' => false
            ]);
    }

    /**
     * Zbudowanie pola typu textarea
     * @param $form
     * @param $it
     */
    protected function buildTextareaField(&$form, $it)
    {
        $form
            ->add($this->getNormalizedFormHash($it['hash']), TextareaType::class, [
                'label' => $it['name'],
                'data' => $it['value'],
                'help' => $it['description'],
                'required' => false,
                'mapped' => false
            ]);
    }

    /**
     * Zbudowanie pola radio
     * @param $form
     * @param $it
     */
    protected function buildChoiceField(&$form, $it)
    {
        $form
            ->add($this->getNormalizedFormHash($it['hash']), ChoiceType::class, [
                'label' => $it['name'],
                'choices' => unserialize($it['options']),
                'data' => $it['value'],
                'help' => $it['description'],
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'mapped' => false
            ]);
    }

    /**
     * Zbudowanie pola typu editor
     * @param $form
     * @param $it
     */
    protected function buildEditorField(&$form, $it)
    {
        $form
            ->add($this->getNormalizedFormHash($it['hash']), CKEditorType::class, [
                'label' => $it['name'],
                'data' => $it['value'],
                'help' => $it['description'],
                'required' => false,
                'mapped' => false
            ]);
    }

    /**
     * @param $hash
     * @return mixed
     */
    protected function getNormalizedFormHash($hash)
    {
        return str_replace('.', '_', $hash);
    }
}

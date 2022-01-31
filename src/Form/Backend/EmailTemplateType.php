<?php

namespace App\Form\Backend;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EmailTemplateType
 * @package App\Form\Backend
 */
class EmailTemplateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'Temat'
            ])
            ->add('contentHtml', CKEditorType::class, [
                'label' => 'Treść HTML',
                'attr' => [
                    'style' => 'height: 500px;'
                ],
                'required' => false
            ])
            ->add('contentText', TextareaType::class, [
                'label' => 'Treść TXT',
                'attr' => [
                    'style' => 'height: 300px;'
                ],
                'required' => false
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

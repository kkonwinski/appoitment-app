<?php

namespace App\Form;

use App\Entity\Service;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'form.service.name',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('duration', TextType::class, [
                'label' => 'form.service.duration',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'form.service.price',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'form.service.description',
                'config' => array('toolbar' => 'basic'),
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}

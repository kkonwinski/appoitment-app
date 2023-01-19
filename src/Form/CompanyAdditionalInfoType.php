<?php

namespace App\Form;

use App\Entity\CompanyAdditionalInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone', TelType::class, [
                'label' => 'form.company_additional_info.phone',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.company_additional_info.email',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('facebook', UrlType::class, [
                'label' => 'form.company_additional_info.facebook',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('instagram', UrlType::class, [
                'label' => 'form.company_additional_info.instagram',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('website', UrlType::class, [
                'label' => 'form.company_additional_info.website',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyAdditionalInfo::class,
            'validation_groups' => ['Default', 'CompanyAdditionalInfo']
        ]);
    }
}

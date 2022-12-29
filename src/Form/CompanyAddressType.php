<?php

namespace App\Form;

use App\Entity\CompanyAdditionalInfo;
use App\Entity\CompanyAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Languages;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'form.company_address.city',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('postCode', TextType::class, [
                'required' => true,
                'label' => 'form.company_address.post_code',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('country', CountryType::class, [
                'required' => true,
                'label' => 'form.company_address.country',
                'data' => 'PL',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('street', TextType::class, [
                'required' => true,
                'label' => 'form.company_address.street',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('buildingNumber', NumberType::class, [
                'required' => true,
                'label' => 'form.company_address.building_number',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add(
                'companyAdditionalInfos',
                CollectionType::class,
                [
                    'entry_type' => CompanyAdditionalInfoType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'label' => 'form.company_address.company_address_label',
//                    'data' => $builder->getData()->getCompanyAdditionalInfos()
                    ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyAddress::class,
        ]);
    }
}

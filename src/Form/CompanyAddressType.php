<?php

namespace App\Form;

use App\Entity\CompanyAddress;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\DependencyInjection\AutocompleteExtension;

class CompanyAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $companyAddress = $builder->getData();
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
                    ]
            )
        ->add('service', EntityType::class, [
            'class' => Service::class,
            'multiple' => true,
            'query_builder' => function (ServiceRepository $er) use ($companyAddress) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC')
                    ->join('s.companyAddresses', 'ca')
                    ->andWhere('ca = :companyAddress')
                    ->andWhere('s.deletedAt IS NULL')
                    ->setParameter('companyAddress', $companyAddress);
            },
            'choice_label' => 'name',
            'label' => 'form.company_address.service_placeholder',
            'autocomplete' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyAddress::class,
        ]);
    }
}

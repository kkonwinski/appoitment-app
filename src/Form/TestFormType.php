<?php

namespace App\Form;

use App\Entity\CompanyAddress;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $companyAddress = $builder->getData();

        $builder
            ->add('city')
            ->add('postCode')
            ->add('country')
            ->add('street')
            ->add('buildingNumber')
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
//            ->add('companyOpenHours', CollectionType::class, [
//                'entry_type' => CompanyOpenHoursType::class,
//                'entry_options' => ['label' => false],
//                'label' => false,
//                'allow_add' => true
//            ])
//            ->add('service', EntityType::class, [
//                'class' => Service::class,
//                'multiple' => true,
//                'query_builder' => function (ServiceRepository $er) use ($companyAddress) {
//                    return $er->createQueryBuilder('s')
//                        ->orderBy('s.name', 'ASC')
//                        ->join('s.companyAddresses', 'ca')
//                        ->andWhere('ca = :companyAddress')
//                        ->andWhere('s.deletedAt IS NULL')
//                        ->setParameter('companyAddress', $companyAddress);
//                },
//                'choice_label' => 'name',
//                'label' => 'form.company_address.service_placeholder',
//                'autocomplete' => true,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyAddress::class,
        ]);
    }
}

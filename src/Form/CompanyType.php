<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'form.company.name',
                'attr' => [
                    'class' => 'form-control',
                    'disabled' => $options['data']->getName() !== null,

                ],
                'empty_data' => $options['data']->getName()
            ])
            ->add(
                'companyAddresses',
                CollectionType::class,
                [
                    'entry_type' => CompanyAddressType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'label' => 'form.company_address.company_address_label',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}

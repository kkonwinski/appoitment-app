<?php

namespace App\Form;

use App\Entity\CompanyAddress;
use App\Entity\Employee;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'form.employee.name',
                'attr' => [
                    'placeholder' => 'form.employee.name',
                    'class' => 'form-control'
                ]
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'form.employee.surname',
                'attr' => [
                    'placeholder' => 'form.employee.surname',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

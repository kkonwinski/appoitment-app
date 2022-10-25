<?php

namespace App\Form;

use App\Entity\EmployeeSchedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dayFrom')
            ->add('dayTo')
            ->add('timeFrom')
            ->add('timeTo')
            ->add('repeatInfinity')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmployeeSchedule::class,
        ]);
    }
}

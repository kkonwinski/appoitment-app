<?php

namespace App\Form;

use App\Entity\EmployeeSchedule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class EmployeeScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'form.employee_schedule.title',
                    'required' => true
                ])
            ->add('dayFrom', DateType::class, [
                'label' => 'form.employee_schedule.day_from',
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker', 'autocomplete' => 'off'],

            ])
            ->add('dayTo', DateType::class, [
                'label' => 'form.employee_schedule.day_to',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker','autocomplete' => 'off'],
            ])
            ->add('timeFrom', TimeType::class, [
                'label' => 'form.employee_schedule.time_from',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker', 'autocomplete' => 'off'],
                'required' => true
            ])
            ->add('timeTo', TimeType::class, [
                'label' => 'form.employee_schedule.time_to',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker', 'autocomplete' => 'off'],
            ])
            ->add('repeatInfinity', CheckboxType::class, [
                'label' => 'form.employee_schedule.repeat_infinity',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => EmployeeSchedule::class,
        ]);
    }
}

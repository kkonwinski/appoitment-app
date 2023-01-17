<?php

namespace App\Form;

use App\Entity\CompanyOpenHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyOpenHoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //create select type with days of week
        $builder
            ->add('dayName', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'form.company_open_hours_days.day_name',
                'choices' => [
                    'form.company_open_hours_days.monday' => 'Monday',
                    'form.company_open_hours_days.tuesday' => 'Tuesday',
                    'form.company_open_hours_days.wednesday' => 'Wednesday',
                    'form.company_open_hours_days.thursday' => 'Thursday',
                    'form.company_open_hours_days.friday' => 'Friday',
                    'form.company_open_hours_days.saturday' => 'Saturday',
                    'form.company_open_hours_days.sunday' => 'Sunday',
                ],
                'required' => true,

            ])
            ->add('openFrom', TimeType::class, [

                'label' => 'form.employee_schedule.time_from',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker', 'autocomplete' => 'off'],
                'required' => true
            ])
            ->add('openTo', TimeType::class, [
                'label' => 'form.employee_schedule.time_to',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker', 'autocomplete' => 'off'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyOpenHours::class,
        ]);
    }
}

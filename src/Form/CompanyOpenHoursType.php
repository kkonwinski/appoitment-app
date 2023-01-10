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
                'choices'  => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyOpenHours::class,
        ]);
    }
}

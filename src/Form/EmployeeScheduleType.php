<?php

namespace App\Form;

use App\Entity\EmployeeSchedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $scheduleEmployee = $options['data'];

        $builder
            ->add('title', TextType::class, [
                    'required' => true
                ])
            ->add('dayFrom', DateType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'data' => $scheduleEmployee ? $scheduleEmployee->getDayFrom() : null,

            ])
            ->add('dayTo', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'data' => $scheduleEmployee ? $scheduleEmployee->getDayTo() : null
            ])
            ->add('timeFrom', TimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker'],
                'data' => $scheduleEmployee ? $scheduleEmployee->getTimeFrom() : null,
                'required' => true
            ])
            ->add('timeTo', TimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-timepicker'],
                'data' => $scheduleEmployee ? $scheduleEmployee->getTimeTo() : null
            ])
            /** TODO poprawić błąd po wysyłce formularza  */
            ->add('repeatInfinity', CheckboxType::class, [
                'required' => false,
                'data' => $scheduleEmployee ? $scheduleEmployee->isRepeatInfinity() : false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data' => EmployeeSchedule::class,
        ]);
    }
}

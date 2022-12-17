<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterApiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $closuresReasons = $options['data'];

        $builder
            ->add('reason', ChoiceType::class, [
                'required' => false,
                'choices' => $closuresReasons,
                'choice_label' => function ($choice, $closuresReasons, $value) {
                    return $value;
                },
                'placeholder' => 'Voir toutes les raisons',
                'label' => 'Raison de fermeture :',
            ])
            ->add('date', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'label' => 'Date :',
            ]);
    }
}
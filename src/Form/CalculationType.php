<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CalculationType extends AbstractType
{

    public static $operators = [
        'Multiply' => '*',
        'Add' => '*',
        'Subtract' => '-',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inputA', IntegerType::class)
            ->add('operator', ChoiceType::class, [
                'choices' => CalculationType::$operators
            ])
            ->add('inputB', IntegerType::class)
            ->add('submit', SubmitType::class);
    }

}
<?php

namespace App\Form\Calculator;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DisplayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equation', TextType::class, [
                'attr' => [
                    'autofocus' => "autofocus",
                    ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => '=',
            ])
            ->setMethod('GET');
    }
}
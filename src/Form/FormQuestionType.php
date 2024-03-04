<?php

namespace App\Form;

use App\Entity\FormQuestion;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FormQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('questionType', ChoiceType::class, [
            'label' => 'Type de question',
            'choices' => [
                'Texte' => 'text',
                'Select' => 'select',
                'Checkbox' => 'checkbox',
            ],
            'expanded' => false,
            'multiple' => false,
        ])

        ->add('isRequired', CheckboxType::class, [
            'label' => 'Question obligatoire',
            'required' => false,
        ])

        ->add('questionText', TextType::class, [
            'label' => 'Texte de la question',
        ])

        ->add('options', CollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'required' => false,
            'entry_options' => [
                'attr' => ['class' => 'option-entry']
            ],
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormQuestion::class,
        ]);
    }
}

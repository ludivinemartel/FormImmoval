<?php

namespace App\Form;

use App\Entity\FormTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('introMessage', TextareaType::class, [
                'required' => false,
                'label' => 'Message introduction'
            ])
            ->add('formQuestions', CollectionType::class, [
                'entry_type' => FormQuestionType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
            ->add('thankYouMessage', TextareaType::class, [
                'required' => false,
                'label' => 'Message de remerciement'
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormTemplate::class,
        ]);
    }
}

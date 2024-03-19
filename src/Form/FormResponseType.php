<?php

namespace App\Form;

use App\Entity\FormQuestion;
use App\Entity\FormResponse;
use App\Entity\FormTemplate;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormResponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FormTextAnswer')
            ->add('Date')
            ->add('mandatDate')
            ->add('venteDate')
            ->add('formResponseId')
            ->add('responseDate')
            ->add('relanceDate')
            ->add('FormTemplateTitle', EntityType::class, [
                'class' => FormTemplate::class,
'choice_label' => 'id',
            ])
            ->add('FormQuestion', EntityType::class, [
                'class' => FormQuestion::class,
'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormResponse::class,
        ]);
    }
}

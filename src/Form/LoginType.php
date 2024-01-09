<?php

namespace App\Form;

use App\Entity\Negociateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])

                ->add('password', TextType::class, [
                    'label' => 'Mot de passe',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    ]) 

                    ->add('submit', SubmitType::class, [
                        'attr' => [
                            'class' => 'btn btn-primary',
                        ],
                        'label' => 'Envoyer'
                        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Negociateur::class,
        ]);
    }
}

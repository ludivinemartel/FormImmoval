<?php

namespace App\Form;

use App\Entity\FormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EstimationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
                
            ->add('forname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('phone', IntegerType::class, [
                'label'=> 'Numéro de téléphone',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('mail', TextType::class, [
                'label'=> 'Adresse mail',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('type', ChoiceType::class, [
                'label'=> 'Type de bien',
                'required' => true,
                'choices' => [
                    'Maison' => 'Maison',
                    'Appartement' => 'Appartement',
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Sélectionnez le type de bien',
            ])
            ->add('adresse', TextType::class, [
                'label'=> 'Saisir l\'adresse du bien à faire estimer 
                (ex : 22 avenue de la Paix 67000 Strasbourg)',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])

            ->add('quartier', ChoiceType::class, [
                'choices' => [
                    'Centre ville' => 'CentreVille',
                    'Quartier Gare' => 'QuartierGare',
                    'Esplanade' => 'Esplanade',
                    'Montagne verte' => 'MontagneVerte',
                    'Hautepierre' => 'Hautepierre',
                    'Cronenbourg' => 'Cronenbourg',
                    'Koenigshoffen' => 'Koenigshoffen',
                    'Elsau' => 'Elsau',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Le quartier',
            ])

            ->add('surface', IntegerType::class, [
                'label' => 'Surface du bien (m²)',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('sejour', IntegerType::class, [
                'label' => 'Surface du séjour (m²)',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('pieces', IntegerType::class, [
                'label'=> 'Nombre de pièces',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('chambres', IntegerType::class, [
                'label'=> 'Nombre de chambre',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('bain', IntegerType::class, [
                'label'=>'Nombre de salle de bain',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('eau', IntegerType::class, [
                'label' => 'Nombre de salle d\'eau',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'A renover' => 'renover',
                    'A rafraichir' => 'rafraichir',
                    'Bon' => 'good',
                    'Très bon' => 'verygood',
                    'Refait à neuf' => 'neuf',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'État général du bien',
            ])

            ->add('locataire', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Locataire en place',
            ])

            ->add('years', ChoiceType::class, [
                'choices' => [
                    'Avant 1800' => '1800',
                    '1800 à 1900' => '1900',
                    '1900 à 1950' => '1950',
                    '1950 à 1980' => '1980',
                    '1980 à 2000' => '2000',
                    '2000 à 2015' => '2015',
                    'Après 2015' => '2016',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Année de construction',
            ])

            ->add('stagehome', TextType::class, [
                'label' => 'Étage de l\'appartement',
                'required' => false, 
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('stage', TextType::class, [
                'label' => 'Nombre d\'étage(s)/niveaux',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])

            ->add('chauffage', ChoiceType::class, [
                'choices' => [
                    'Individuel' => 'individuel',
                    'Collectif' => 'collectif',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Chauffage',
            ])

            ->add('balcon', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3 et plus' => '3',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Balcon',
            ])

            ->add('terrasse', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3 et plus' => '3',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Terrasse',
            ])

            ->add('cave', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'yes',
                    'Non' => 'no',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Cave',
            ])

            ->add('parking', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3 et plus' => '3',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Parking',
            ])

            ->add('garage', ChoiceType::class, [
                'choices' => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3 et plus' => '3',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Garage',
            ])

            ->add('view', ChoiceType::class, [
                'choices' => [
                    'Proche' => 'proche',
                    'Normal' => 'normal',
                    'Éloigné' => 'eloigne',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Vis-à-vis',
            ])

            ->add('exposition', ChoiceType::class, [
                'choices' => [
                    'Nord' => 'nord',
                    'Sud' => 'sud',
                    'Est' => 'est',
                    'Ouest' => 'ouest',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Exposition principale',
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'label' => 'Envoyer'
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FormData::class,
        ]);
    }
}

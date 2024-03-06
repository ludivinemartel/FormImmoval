<?php

namespace App\Controller\Admin;

use App\Entity\FormTemplate;
use App\Form\FormQuestionType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class FormTemplateCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return FormTemplate::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->setLabel('Modifier')->setIcon('fa fa-edit');
        })
        ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
            return $action->setLabel('Supprimer')->setIcon('fa fa-trash');
        })

        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
            return $action->setLabel('Enregistrer et retourner')->setIcon('fa fa-save');
        })
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
            return $action->setLabel('Enregistrer')->setIcon('fa fa-save');
        })

        ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
            return $action->setLabel('Enregistrer')->setIcon('fa fa-save');
        })
       
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
            return $action->setLabel('Enregistrer et ajouter un autre')->setIcon('fa fa-save');
        })
      
  
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setLabel('Ajouter un formulaire')->setIcon('fa fa-plus');
        })

        ->add(Crud::PAGE_EDIT, Action::new('showFormFront', 'Voir le formulaire', 'fa fa-eye')->linkToRoute('form_show', function (FormTemplate $formTemplate) {
            return ['formTemplateId' => $formTemplate->getId()];
        }))
        ->add(Crud::PAGE_NEW, Action::new('showFormFront', 'Voir le formulaire', 'fa fa-eye')->linkToRoute('form_show', function (FormTemplate $formTemplate) {
            return ['formTemplateId' => $formTemplate->getId()];
        }));
    }

    public function configureFields(string $pageName): iterable
{
    return [
        TextField::new('title')->setLabel('Titre du formulaire'),
        TextareaField::new('introMessage')->setLabel('Message introduction')->onlyOnForms(),
        CollectionField::new('formQuestions')->setLabel('Questions du formulaire')
            ->setEntryType(FormQuestionType::class)
            ->onlyOnForms(),
        TextareaField::new('thankYouMessage')->setLabel('Message de remerciement')->onlyOnForms(),
        SlugField::new('slug')
        ->setTargetFieldName('title')
        ->hideOnDetail()
        ->hideOnIndex(),
    ];
}
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Modifier questionnaire')
            ->setPageTitle('new', 'Créer un nouveau questionnaire')
            ->setEntityLabelInSingular('Formulaire')
            ->setEntityLabelInPlural('Formulaires');
    }
}
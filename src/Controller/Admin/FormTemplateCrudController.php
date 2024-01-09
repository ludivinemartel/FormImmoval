<?php

namespace App\Controller\Admin;

use App\Entity\FormTemplate;
use App\Form\FormQuestionType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FormTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FormTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            CollectionField::new('formQuestions')
            ->setEntryType(FormQuestionType::class)
            ->onlyOnForms(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Modifier questionnaire');
    }
}


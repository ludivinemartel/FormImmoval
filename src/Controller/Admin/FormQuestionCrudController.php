<?php

namespace App\Controller\Admin;

use App\Entity\FormQuestion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FormQuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FormQuestion::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

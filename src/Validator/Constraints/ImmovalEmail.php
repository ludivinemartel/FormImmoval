<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ImmovalEmail extends Constraint
{
    public $message = 'L\'adresse e-mail doit se terminer par "@immoval.com".';
}

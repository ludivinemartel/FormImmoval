<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImmovalEmailValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (!is_string($value) || $value === '') {
            return;
        }

        if (!preg_match('/@immoval\.com$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}

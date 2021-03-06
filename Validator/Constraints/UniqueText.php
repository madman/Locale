<?php

namespace FDevs\Locale\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueText extends Constraint
{
    public $message = "This value '%value%' with locale '%locale%' is already used.";

    /** @var string */
    public $service = 'f_devs_locale.validator.unique_text';

    /**
     * {@inheritDoc}
     */
    public function validatedBy()
    {
        return $this->service;
    }
}

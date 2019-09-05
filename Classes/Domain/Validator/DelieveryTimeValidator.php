<?php

namespace MyVendor\SitePackage\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class DelieveryTimeValidator extends AbstractValidator
{
    /**
     * @param mixed $value
     * @return void
     */
    protected function isValid($value) : void
    {
        if(is_integer($value) && $value > 0 && $value <= 1000) {
            return;
        }
        $this->addError('The quantity was not a value between 0 and 1000.', 5009832);
    }
}
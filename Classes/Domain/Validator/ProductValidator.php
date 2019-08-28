<?php

namespace MyVendor\SitePackage\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

//NOTE: This class validates the model "Product" as a whole!
class ProductValidator extends AbstractValidator
{
    protected function isValid($value)
    {
        if(is_string($value->getName())) {
            return;
        } else {
            $this->addError('product.name:The name has to be a string!', 334769);
        }
    }
}
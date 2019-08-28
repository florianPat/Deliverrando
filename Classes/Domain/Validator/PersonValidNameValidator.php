<?php

namespace MyVendor\SitePackage\Domain\Validator;

use \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class PersonValidNameValidator extends AbstractValidator
{
    /**
     * @var \MyVendor\SitePackage\Domain\Repository\PersonRepository
     * @inject
     */
    private $personRepository;

    protected function isValid($value)
    {
        if($this->personRepository->findByName($value->getName()) === null) {
            return;
        } else {
            $this->addError("person.name:The name is already registered!", 2839283);
        }
    }
}
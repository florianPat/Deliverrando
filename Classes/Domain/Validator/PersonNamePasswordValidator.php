<?php

namespace MyVendor\SitePackage\Domain\Validator;

use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class PersonNamePasswordValidator extends AbstractValidator
{
    /**
     * @var \MyVendor\SitePackage\Domain\Repository\PersonRepository
     * @inject
     */
    private $personRepository;

    protected function isValid($value)
    {
        $person = $this->personRepository->findByIdentifier($value->getName());

        if($person !== null) {
            if(password_verify($value->getPassword(), $person->getPassword())) {
                return;
            } else {
                $this->addError("This is the wrong password!");
            }
        } else {
            $this->addError("The name is not registered yet!", 3928395);
        }
    }
}
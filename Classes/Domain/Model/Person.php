<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Person extends AbstractEntity
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     * @\TYPO3\CMS\Extbase\Annotation\Validate("NumberValidator")
     */
    protected $telephonenumber;

    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $name
     * @param string $address
     * @param string $telephonenumber
     * @param string $password
     */
    public function __construct($name, $address, $telephonenumber, $password)
    {
        $this->name = $name;
        $this->address = $address;
        $this->telephonenumber = $telephonenumber;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param string $telephonenumber
     * @return void
     */
    public function setTelephonenumber($telephonenumber)
    {
        $this->telephonenumber = $telephonenumber;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTelephonenumber()
    {
        return $this->telephonenumber;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
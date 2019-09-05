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
    protected $password;

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     * @\TYPO3\CMS\Extbase\Annotation\Validate("NumberValidator")
     */
    protected $telephonenumber = '';

    /**
     * @param string $name
     * @param string $password
     * @param string $address
     * @param string $telephonenumber
     */
    public function __construct($name, $password, $address = '', $telephonenumber = '')
    {
        $this->name = $name;
        $this->password = $password;
        $this->address = $address;
        $this->telephonenumber = $telephonenumber;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }


    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    /**
     * @param string $address
     * @return void
     */
    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    /**
     * @param string $telephonenumber
     * @return void
     */
    public function setTelephonenumber(string $telephonenumber) : void
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
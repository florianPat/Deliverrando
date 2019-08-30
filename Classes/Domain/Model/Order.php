<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Order extends AbstractEntity
{
    /**
     * @var \MyVendor\SitePackage\Domain\Model\Person
     */
    protected $person;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Product>
     */
    protected $products;

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $person
     */
    public function __construct(\MyVendor\SitePackage\Domain\Model\Person $person = null)
    {
        $this->person = $person;
        $this->products = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $person
     */
    public function setPerson(\MyVendor\SitePackage\Domain\Model\Person $person)
    {
        $this->person = $person;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $products
     * @return void
     */
    public function setProducts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $products)
    {
        $this->products = $products;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     */
    public function addProduct(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $this->products->attach($product);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function removeProduct(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $this->products->detach($product);
    }

    /**
     * @return \MyVendor\SitePackage\Domain\Model\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getProducts()
    {
        return $this->products;
    }
}
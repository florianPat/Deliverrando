<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Delieverrando extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Product>
     * This tells extbase to only load the objects if they are needed, and not to load all child objects wich are associated with Delieverrando
     * (that would be called Eager-Loading)
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * This tells extbase to delete the products if the Delieverrando gets deleted
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $products;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup
     */
    protected $userGroup;

    /**
     * @param string $name
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup
     */
    public function __construct($name = '', \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup = null)
    {
        $this->name = $name;
        $this->products = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->userGroup = $userGroup;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
      * @param \MyVendor\SitePackage\Domain\Model\Product $product
      * @return void
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
      * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Products>
      * @return void
      */
    public function setProducts(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $products)
    {
        $this->products = $products;
    }

    /**
      * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Product>
      */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup
     * @return void
     */
    public function setUserGroup(\TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup)
    {
        $this->userGroup = $userGroup;
    }
}
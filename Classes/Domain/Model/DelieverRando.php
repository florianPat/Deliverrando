<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class DelieverRando extends AbstractEntity
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Product>
     * This tells extbase to only load the objects if they are needed, and not to load all child objects wich are associated with DelieverRando
     * (this is called Eager-Loading)
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * This tells extbase to delete the products if the DelieverRando gets deleted
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $products;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup
     */
    protected $userGroup;

    /**
     * @param string $name
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Product> $products
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup
     */
    public function __construct(string $name = '', \TYPO3\CMS\Extbase\Persistence\ObjectStorage $products = null,
                                \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $userGroup = null)
    {
        $this->name = $name;
        $this->products = $products;
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
        return clone $this->products;
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
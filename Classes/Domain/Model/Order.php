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
     * @var array
     */
    protected $productQuantities;

    /**
     * @var int
     */
    protected $deliverytime;

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $person
     */
    public function __construct(\MyVendor\SitePackage\Domain\Model\Person $person = null)
    {
        $this->person = $person;
        $this->products = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->productQuantities = [];
        $this->deliverytime = 0;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $person
     * @return void
     */
    public function setPerson(\MyVendor\SitePackage\Domain\Model\Person $person) : void
    {
        $this->person = $person;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    private function addProduct(\MyVendor\SitePackage\Domain\Model\Product $product) : void
    {
        $this->products->attach($product);
    }

    /**
     * @param int $quantity
     * @return void
     */
    private function addQuantity(int $quantity) : void
    {
        array_push($this->productQuantities, $quantity);
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return void
     */
    public function addProductDescription(\MyVendor\SitePackage\Domain\Model\Product $product, int $quantity) : void
    {
        $this->addProduct($product);
        $this->addQuantity($quantity);
    }

    /**
     * @return array
     */
    public function getProductDescriptions() : array
    {
        $result = [];

        $length = count($this->productQuantities);
        for($i = 0, $this->products->rewind(); $i < $length; ++$i, $this->products->next()) {
            $product = $this->products->current();
            assert($product);
            $quantity = $this->productQuantities[$i];

            array_push($result, new Helper\ProductDescription($product, $quantity));
        }

        return $result;
    }

    /**
     * @param int $deliverytime
     * @return void
     */
    public function setDeliverytime(int $deliverytime) : void
    {
        $this->deliverytime = $deliverytime;
    }

    /**
     * @return \MyVendor\SitePackage\Domain\Model\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @return int
     */
    public function getDeliverytime()
    {
        return $this->deliverytime;
    }
}
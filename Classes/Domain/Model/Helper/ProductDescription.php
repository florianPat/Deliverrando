<?php

namespace MyVendor\SitePackage\Domain\Model\Helper;

class ProductDescription
{
    /**
     * @var \MyVendor\SitePackage\Domain\Model\Product
     */
    private $product;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @param int $quantity
     */
    public function __construct(\MyVendor\SitePackage\Domain\Model\Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return \MyVendor\SitePackage\Domain\Model\Product
     */
    public function getProduct() : \MyVendor\SitePackage\Domain\Model\Product
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity() : int
    {
        return $this->quantity;
    }
}
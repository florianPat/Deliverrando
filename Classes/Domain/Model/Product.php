<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Product extends AbstractEntity
{
    /**
    *  @var string
    * @\TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 3, "maximum": 30})
    */
    protected $name;

    /**
    *  @var string
     * @\TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"maximum": 100})
    */
    protected $description;

    /**
    *  @var int
    * @\TYPO3\CMS\Extbase\Annotation\Validate("MyVendor\SitePackage\Domain\Validator\DelieveryTimeValidator", options={"maximum": 1000})
    */
    protected $quantity;

    /**
    * @var int
    * @\TYPO3\CMS\Extbase\Annotation\Validate("MyVendor\SitePackage\Domain\Validator\DelieveryTimeValidator", options={"maximum": 100})
    */
    protected $deliverytime;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $categories;

    /**
     * @var \MyVendor\SitePackage\Domain\Model\Delieverrando $delieverrando
     */
    protected $delieverrando;

    /**
    *  @param string $name
    *  @param string $description
    *  @param int $quantity
    *  @param int $deliverytime
    */
    public function __construct($name = '', $description = '', $quantity = 0, $deliverytime = 0)
    {
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->deliverytime = $deliverytime;
        $this->categories = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
    *  @return string
    */
    public function getName()
    {
        return $this->name;
    }

    /**
    *  @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
    *  @return int
    */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
      * @return int
      */
    public function getDeliverytime()
    {
        return $this->deliverytime;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return \MyVendor\SitePackage\Domain\Model\Delieverrando
     */
    public function getDelieverrando()
    {
        return $this->delieverrando;
    }

    /**
     *  @param string $name
     *  @return void
     */
     public function setName(string $name) : void
     {
         $this->name = $name;
     }

     /**
      *  @param string $description
      *  @return void
      */
      public function setDescription(string $description) : void
      {
          $this->description = $description;
      }

      /**
       *  @param int $quantity
       *  @return void
       */
       function setQuantity(int $quantity) : void
       {
           $this->quantity = $quantity;
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
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories) : void
    {
        $this->categories = $categories;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\MyVendor\SitePackage\Domain\Model\Category $category) : void
    {
        $this->categories->attach($category);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Category $category
     * @return void
     */
    public function removeCategory(\MyVendor\SitePackage\Domain\Model\Category $category) : void
    {
        $this->categories->detach($category);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Delieverrando $delieverrando
     * @return void
     */
    public function setDelieverrando(\MyVendor\SitePackage\Domain\Model\Delieverrando $delieverrando) : void
    {
        $this->delieverrando = $delieverrando;
    }
}

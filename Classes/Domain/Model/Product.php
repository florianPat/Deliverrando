<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Product extends AbstractEntity
{
  /**
   *  @var string
   * @TYPO3\CMS\Extbase\Annotation\Validate("StringLength", options={"minimum": 3, "maximum": 30})
   */
  protected $name = '';

  /**
   *  @var string
   */
  protected $description = '';

  /**
   *  @var int
   */
  protected $quantity = 0;

  /**
    * @var int
    */
    protected $delieveryTime = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     */
    protected $categories = null;

  /**
   *  @param string $name
   *  @param string $description
   *  @param int $quantity
   *  @param int $§delieveryTime
   *  @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category> $categories
   */
  public function __construct($name = '', $description = '', $quantity = 0, $delieveryTime = 0,
                              \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories = null)
  {
    $this->name = $name;
    $this->description = $description;
    $this->quantity = $quantity;
    $this->delieveryTime = $delieveryTime;
    $this->categories = $categories;
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
    public function getDelieveryTime()
    {
        return $this->delieveryTime;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     */
    public function getClonedCategories()
    {
        return clone $this->categories;
    }

    /**
     *  @param string $name
     *  @return void
     */
     public function setName($name)
     {
       $this->name = $name;
     }

     /**
      *  @param string $description
      *  @return void
      */
      public function setDescription($description)
      {
        $this->description = $description;
      }

      /**
       *  @param int $quantity
       *  @return void
       */
       function setQuantity($quantity)
       {
         $this->quantity = $quantity;
       }

       /**
         * @param int $delieveryTime
         * @return void
         */
       public function setDelieveryTime($delieveryTime)
       {
           $this->delieveryTime = $delieveryTime;
       }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MyVendor\SitePackage\Domain\Model\Category>
     * @return void
     */
       public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
       {
           $this->categories = $categories;
       }
}

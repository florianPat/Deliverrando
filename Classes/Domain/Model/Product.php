<?php

namespace MyVendor\SitePackage\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Product extends AbstractEntity
{
  /**
   *  @var string
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
   *  @param string $name
   *  @param string $description
   *  @param int $quantity
   */
  public function __construct($name = '', $description = '', $quantity = 0)
  {
    $this->name = $name;
    $this->description = $description;
    $this->$quantity = $quantity;
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
}

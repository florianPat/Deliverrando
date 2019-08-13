<?php

namespace MyVendor\SitePackage\Controller;

use MyVendor\SitePackage\Domain\Repository\ProductRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 *  @package MyVendor\SitePackage\Controller
 */
class StoreInventoryController extends ActionController
{
  /**
   *  @var \MyVendor\SitePackage\Domain\Repository\ProductRepository
   */
  private $productRepository;

  /**
   *  @param \MyVendor\SitePackage\Domain\Repository\ProductRepository $productRepository
   *  @return void
   */
  public function injectProductRepository(ProductRepository $productRepository)
  {
    $this->productRepository = $productRepository;
  }

  /**
   *  @return void
   */
  public function indexAction()
  {
    $products = $this->productRepository->findAll();

    $this->view->assign('products', $products);
  }
}

<?php

namespace MyVendor\SitePackage\Controller;

use MyVendor\SitePackage\Domain\Model\Product;
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
     * @var \MyVendor\SitePackage\Domain\Repository\DelieverRandoRepository
     */
    private $delieverRandoRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\CategoryRepository
     * @inject
     * NOTE: Has the same effect as declaring the method injectCategoryRepository
     */
    private $categoryRepository;

    /**
    *  @param \MyVendor\SitePackage\Domain\Repository\ProductRepository $productRepository
    *  @return void
    */
    public function injectProductRepository(\MyVendor\SitePackage\Domain\Repository\ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Repository\DelieverRandoRepository $delieverRandoRepository
     * @return void
     */
    public function injectDelieverRandoRepository(\MyVendor\SitePackage\Domain\Repository\DelieverRandoRepository $delieverRandoRepository)
    {
      $this->delieverRandoRepository = $delieverRandoRepository;
    }

  /**
   * @param string $messageText
   * @param \MyVendor\SitePackage\Domain\Model\Product $product
   * @param array $errores
   * @return void
   */
    public function indexAction(string $messageText = '', \MyVendor\SitePackage\Domain\Model\Product $product = null, $errors = null)
    {
        if($errors !== null) {
            $this->view->assign('errors', $errors);
        }

        if($messageText !== '') {
            assert($product !== null);
            $this->view->assign("messageText", $messageText);
            $this->view->assign('messageProduct', $product);

            $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
            $persistenceManager->persistAll();
        }

        if($GLOBALS['TSFE']->fe_user->user['uid']) {
            $allCategories = $this->categoryRepository->findAll();
            $categoryOptions = [0 => ''];
            $allCategories->rewind();
            while($allCategories->valid()) {
              $it = $allCategories->current();

              $categoryOptions[$it->getUid()] = $it->getName();

              $allCategories->next();
            }
            $this->view->assign('categoryOptions', $categoryOptions);

//          $userGroupUid = $GLOBALS['TSFE']->fe_user->user['usergroup'];
//
//          $delieverServiceProducts = '';
//          $delieverServiceProducts .= $this->delieverRandoRepository->findProductsByUserGroup($userGroupUid);
//          $userGroupName = $this->delieverRandoRepository->findUserGroupName($userGroupUid);
//
//          for($subGroup = $this->delieverRandoRepository->findSubGroup($userGroupUid);
//              $subGroup != -1;
//              $subGroup = $this->delieverRandoRepository->findSubGroup($subGroup))
//          {
//              $delieverServiceProducts .= ',' . $this->delieverRandoRepository->findProductsByUserGroup($subGroup);
//          }
//
//          $products = $this->productRepository->findByUids($delieverServiceProducts);
//
//          $this->view->assign('userGroupName', $userGroupName);
//          $this->view->assign('products', $products);
            $this->view->assign('products', $this->productRepository->findAll());
        } else {
          $this->view->assign('products', $this->productRepository->findAll());
        }
     }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function showAction(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $this->view->assign('product', $product);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return string
     */
    public function removeAction(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $this->productRepository->remove($product);

        $this->forward('index', null, null, ['messageText' => 'Removed', 'product' => $product]);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function updateAction(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $this->productRepository->update($product);

        $this->forward('index', null, null, ['messageText' => 'Updated', 'product' => $product]);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     *
     * NOTE: One can use @   TYPO3\CMS\Extbase\Annotation\IgnoreValidation("argument") to irgnore the argument validation that happens
     * automatically.
     * NOTE: Before the action runs, the arguments are validated. The annotations from the properties, the Validator with
     * the name \MyVendor\SitePackage\Domain\Validator\ClassnameValidator, and the annotations in the action
     */
    public function addAction($product)
    {
        $this->productRepository->add($product);
        $this->forward('index', null, null, ['messageText' => 'Added', 'product' => $product]);
    }
}

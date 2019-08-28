<?php

namespace MyVendor\SitePackage\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class StoreInventoryController extends ActionController
{
    /**
    *  @var \MyVendor\SitePackage\Domain\Repository\ProductRepository
    */
    private $productRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\DelieverrandoRepository
     * @inject
     * NOTE: Has the same effect as declaring the method injectCategoryRepository
     */
    private $delieverrandoRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\CategoryRepository
     * @inject
     */
    private $categoryRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\PersonRepository
     * @inject
     */
    private $personRepository;

    /**
    *  @param \MyVendor\SitePackage\Domain\Repository\ProductRepository $productRepository
    *  @return void
    */
    public function injectProductRepository(\MyVendor\SitePackage\Domain\Repository\ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \MyVendor\SitePackage\Domain\Model\Delieverrando
     */
    private function getDelieverRandoFromLoggedInUser()
    {
        assert($GLOBALS['TSFE']->fe_user->user !== null);
        $userGroupUid = $GLOBALS['TSFE']->fe_user->user['uid'];
        $delieverrandoUid = $this->delieverrandoRepository->findDelieverRandoUid($userGroupUid);
        $result = $this->delieverrandoRepository->findByUid($delieverrandoUid);
        assert($result !== null);
        return $result;
    }

    /**
     * @return void
     */
    private function addCategoryFromOption()
    {
        $allCategories = $this->categoryRepository->findAll();
        $categoryOptions = [0 => ''];
        $allCategories->rewind();
        while($allCategories->valid()) {
            $it = $allCategories->current();

            $categoryOptions[$it->getUid()] = $it->getName();

            $allCategories->next();
        }
        $this->view->assign('categoryOptions', $categoryOptions);
    }

    /**
     * @param string $messageText
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
    */
    public function indexAction($messageText = '', \MyVendor\SitePackage\Domain\Model\Product $product = null)
    {
        session_start();
        if(isset($_SESSION['uid'])) {
            $this->view->assign('personLoggedIn', 'true');
        }
        if(isset($_SESSION['lastAction'])) {
            $this->view->assign('lastAction', $_SESSION['lastAction']);
        }

        if($messageText !== '') {
            assert($product !== null);
            $this->view->assign("messageText", $messageText);
            $this->view->assign('messageProduct', $product);

            $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
            $persistenceManager->persistAll();
        }

        if($GLOBALS['TSFE']->fe_user->user['uid']) {
            $this->addCategoryFromOption();

            $userGroupUid = $GLOBALS['TSFE']->fe_user->user['usergroup'];

            $delieverrandoUids = $this->delieverrandoRepository->findDelieverRandoUidsForUserGroup($userGroupUid);
            $products = $this->productRepository->findAllWithDieverRandoUids($delieverrandoUids);

            $this->view->assign('products', $products);
            $this->view->assign('delieverrandoName', $this->delieverrandoRepository->findDelieverRandoName($delieverrandoUids[0]));
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
     * @return void
     */
    public function removeAction(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        $delieverrando = $this->getDelieverRandoFromLoggedInUser();
        $delieverrando->removeProduct($product);
        $this->delieverrandoRepository->update($delieverrando);

        //NOTE: Druch forward werden die Daten nicht persistet (es wird kein neuer request-response cycle erstellt)
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
     * @param int $category
     * @return void
     *
     * NOTE: One can use @   TYPO3\CMS\Extbase\Annotation\IgnoreValidation("argument") to irgnore the argument validation that happens
     * automatically.
     * NOTE: Before the action runs, the arguments are validated. The annotations from the properties, the Validator with
     * the name \MyVendor\SitePackage\Domain\Validator\ClassnameValidator, and the annotations in the action
     */
    public function addAction(\MyVendor\SitePackage\Domain\Model\Product $product, $category)
    {
        $categoryObj = $this->categoryRepository->findByUid($category);
        if($categoryObj !== null) {
            $product->addCategory($categoryObj);
        } elseif($category !== 0) {
            //TODO: Show error!
        }

        $delieverrando = $this->getDelieverRandoFromLoggedInUser();
        $product->setDelieverrando($delieverrando);
        $delieverrando->addProduct($product);
        $this->delieverrandoRepository->update($delieverrando);

        $this->forward('index', null, null, ['messageText' => 'Added', 'product' => $product]);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $person
     * @\TYPO3\CMS\Extbase\Annotation\Validate("\MyVendor\SitePackage\Domain\Validator\PersonNamePasswordValidator", param="person")
     * @return void
     */
    public function loginAction(\MyVendor\SitePackage\Domain\Model\Person $person)
    {
        $loginPerson = $this->personRepository->findByName($person->getName());

        session_start();
        $_SESSION['uid'] = $loginPerson->getUid();

        $this->redirect('index');
    }

    /**
     * @return void
     */
    public function logoutAction()
    {
        session_start();
        assert(isset($_SESSION['uid']));
        unset($_SESSION['uid']);

        session_destroy();

        $this->redirect('index');
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $registerPerson
     * @\TYPO3\CMS\Extbase\Annotation\Validate("\MyVendor\SitePackage\Domain\Validator\PersonValidNameValidator", param="person")
     * @return void
     */
    public function registerAction(\MyVendor\SitePackage\Domain\Model\Person $person)
    {
        $person->setPassword(password_hash($person->getPassword(), PASSWORD_DEFAULT));
        $this->personRepository->add($person);

        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
        $persistenceManager->persistAll();

        session_start();
        $_SESSION['uid'] = $person->getUid();

        $this->redirect('index');
    }

    /**
     *
     * @return void
     */
    public function initializeAction()
    {
        $actionName = $this->resolveActionMethodName();
        if($actionName !== 'indexAction') {
            session_start();

            $_SESSION['lastAction'] = $actionName;
        }
    }
}

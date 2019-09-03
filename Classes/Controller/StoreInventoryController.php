<?php

namespace MyVendor\SitePackage\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
     * @var \MyVendor\SitePackage\Domain\Repository\OrderRepository
     * @inject
     */
    private $orderRepository;

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
        $userGroupUid = GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('frontend.user', 'id');
        assert($userGroupUid !== null);
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

        foreach($allCategories as $it) {
            $categoryOptions[$it->getUid()] = $it->getName();
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
        if($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid') !== null) {
            $this->view->assign('personLoggedIn', 'true');
        }
        if($GLOBALS['TSFE']->fe_user->getKey('ses', 'lastAction') !== null) {
            $this->view->assign('lastAction', $GLOBALS['TSFE']->fe_user->getKey('ses', 'lastAction'));
        }
        if($GLOBALS['TSFE']->fe_user->getKey('ses', 'orderProducts') !== null) {
            $sesOrderProducts = $GLOBALS['TSFE']->fe_user->getKey('ses', 'orderProducts');
            $renderOrderProducts = [];
            foreach($sesOrderProducts as $key => $it) {
                $product = $this->productRepository->findByUid($key);
                assert($product !== null);
                array_push($renderOrderProducts, $product->getName());
            }
            $this->view->assign('orderProducts', $renderOrderProducts);
        }

        if($messageText !== '') {
            assert($product !== null);
            $this->view->assign("messageText", $messageText);
            $this->view->assign('messageProduct', $product);

            $persistenceManager = $this->objectManager->get(PersistenceManager::class);
            $persistenceManager->persistAll();
        }

        if($GLOBALS['TSFE']->loginUser) {
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

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'uid', $loginPerson->getUid());

        $this->redirect('index');
    }

    /**
     * @return void
     */
    public function logoutAction()
    {
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'uid', null);

        $this->redirect('index');
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $registerPerson
     * @\TYPO3\CMS\Extbase\Annotation\Validate("\MyVendor\SitePackage\Domain\Validator\PersonValidNameValidator", param="person")
     * @return void
     */
    public function registerAction(\MyVendor\SitePackage\Domain\Model\Person $person)
    {
        $passwordHash = GeneralUtility::makeInstance(PasswordHashFactory::class)->getDefaultHashInstance('FE');

        $person->setPassword($passwordHash->getHashedPassword($person->getPassword()));
        $this->personRepository->add($person);

        $persistenceManager = $this->objectManager->get("TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager");
        $persistenceManager->persistAll();

        $GLOBALS['TSFE']->fe_user->setKey('ses','uid', $person->getUid());

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
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'lastAction', $actionName);
        }
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function startOrderAction(\MyVendor\SitePackage\Domain\Model\Product $product)
    {
        assert($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid') !== null);

        $orders = $GLOBALS['TSFE']->fe_user->getKey('ses', 'orderProducts');

        if($orders !== null) {
            $orders[$product->getUid()] += 1;
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'orderProducts', $orders);
        } else {
            $orders = [$product->getUid() => 1];
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'orderProducts', $orders);
        }

        $this->redirect('index');
    }

    /**
     * @return void
     */
    public function endOrderAction()
    {
        assert($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid') !== null);

        $loggedInPerson = $this->personRepository->findByUid($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid'));
        assert($loggedInPerson !== null);
        $order = new \MyVendor\SitePackage\Domain\Model\Order($loggedInPerson);

        $deliverytime = 0;

        for($i = 0; isset($_POST['products' . $i]); ++$i) {
            $product = $this->productRepository->findOneByName(GeneralUtility::_POST('products' . $i));
            assert($product !== null);

            if($product->getDeliverytime() > $deliverytime) {
                $deliverytime = $product->getDeliverytime();
            }

            $order->addProduct($product);
        }
        $order->setDeliverytime($deliverytime);

        $this->orderRepository->add($order);

        $email = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $email->setSubject("Delieverrando order");
        $email->setFrom(['order@delieverrando.com' => 'Delieverrando']);
        $email->setTo(['bla@gmail.com' => $loggedInPerson->getName()]);
        $email->setBody("You ordered food!\nIt will be delivered in: " . $order->getDeliverytime() . " minutes!");
        $email->send();

        $this->forward('finishOrder', null, null, ['order' => $order]);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Order $order
     * @return void
     */
    public function finishOrderAction(\MyVendor\SitePackage\Domain\Model\Order $order)
    {
        $this->view->assign('deliverytime', $order->getDeliverytime());
    }
}

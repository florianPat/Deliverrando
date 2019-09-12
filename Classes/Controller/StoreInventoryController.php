<?php

namespace MyVendor\SitePackage\Controller;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

class StoreInventoryController extends ActionController implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
    *  @var \MyVendor\SitePackage\Domain\Repository\ProductRepository
    */
    private $productRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\DelieverrandoRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     * NOTE: Has the same effect as declaring the method injectCategoryRepository
     */
    private $delieverrandoRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\CategoryRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    private $categoryRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\PersonRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    private $personRepository;

    /**
     * @var \MyVendor\SitePackage\Domain\Repository\OrderRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
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
    private function getDelieverRandoFromLoggedInUser() : \MyVendor\SitePackage\Domain\Model\Delieverrando
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
    private function addCategoryFromOption() : void
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
     * @param string $isoDatetime
     * @return bool
     */
    private function isOpened(string $isoDatetime) : bool
    {
        $startTimePos = strpos($isoDatetime, 'T') + 1;
        $endTimePos = strpos($isoDatetime, '+');
        $isoTime = substr($isoDatetime, $startTimePos, $endTimePos - $startTimePos);
        $hourEndPos = strpos($isoTime, ':');
        $hour = intval(substr($isoTime, 0, $hourEndPos));
        return ($hour > 8 && $hour < 10);
    }

    /**
     * @return void
     */
    private function persistAll() : void
    {
        $this->objectManager->get(PersistenceManager::class)->persistAll();
    }

    /**
     * @param string $messageText
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
    */
    public function indexAction(string $messageText = '', \MyVendor\SitePackage\Domain\Model\Product $product = null) : void
    {
        $context = GeneralUtility::makeInstance(Context::class);

        if($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid') !== null) {
            $this->view->assign('personLoggedIn', 'true');
            //if($this->isOpened($context->getPropertyFromAspect('date', 'iso'))) {
                $this->view->assign('opened', true);
            //}
        } else {
            $this->view->assign('opened', true);
        }
        if($GLOBALS['TSFE']->fe_user->getKey('ses', 'lastAction') !== null) {
            $this->view->assign('lastAction', $GLOBALS['TSFE']->fe_user->getKey('ses', 'lastAction'));
        }

        if($messageText !== '') {
            assert($product !== null);
            $this->view->assign("messageText", $messageText);
            $this->view->assign('messageProduct', $product);

            $this->persistAll();
        }

        if($context->getPropertyFromAspect('frontend.user', 'isLoggedIn')) {
            $this->addCategoryFromOption();

            $userGroupUids = $context->getPropertyFromAspect('frontend.user', 'groupIds');
            //NOTE: TODO: This is kind of a hack
            $userGroupUid = $userGroupUids[count($userGroupUids) - 1];

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
    public function showAction(\MyVendor\SitePackage\Domain\Model\Product $product) : void
    {
        $this->view->assign('product', $product);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function removeAction(\MyVendor\SitePackage\Domain\Model\Product $product) : void
    {
        $this->productRepository->remove($product);

        //NOTE: Druch forward werden die Daten nicht persistet (es wird kein neuer request-response cycle erstellt)
        $this->forward('index', null, null, ['messageText' => 'Removed', 'product' => $product]);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Product $product
     * @return void
     */
    public function updateAction(\MyVendor\SitePackage\Domain\Model\Product $product) : void
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
    public function addAction(\MyVendor\SitePackage\Domain\Model\Product $product, int $category) : void
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
    public function loginAction(\MyVendor\SitePackage\Domain\Model\Person $person) : void
    {
        $loginPerson = $this->personRepository->findByName($person->getName());

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'uid', $loginPerson->getUid());

        $this->redirect('index');
    }

    /**
     * @return void
     */
    public function logoutAction() : void
    {
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'uid', null);

        $this->redirect('index');
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $registerPerson
     * @\TYPO3\CMS\Extbase\Annotation\Validate("\MyVendor\SitePackage\Domain\Validator\PersonValidNameValidator", param="person")
     * @return void
     */
    public function registerAction(\MyVendor\SitePackage\Domain\Model\Person $person) : void
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
     * @return void
     */
    public function initializeAction() : void
    {
        $actionName = $this->resolveActionMethodName();
        if($actionName !== 'indexAction') {
            $GLOBALS['TSFE']->fe_user->setKey('ses', 'lastAction', $actionName);
        }
    }

    public function initializeEndOrderAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $loggedInPerson
     * @return \MyVendor\SitePackage\Domain\Model\Order
     */
    private function setupOrderFromPostArguments(\MyVendor\SitePackage\Domain\Model\Person $loggedInPerson) : \MyVendor\SitePackage\Domain\Model\Order
    {
        $order = new \MyVendor\SitePackage\Domain\Model\Order($loggedInPerson);

        $deliverytime = 0;

        for($i = 0; GeneralUtility::_POST('products' . $i) !== null; ++$i) {
            $product = $this->productRepository->findOneByName(GeneralUtility::_POST('products' . $i));
            $productQuantity = GeneralUtility::_POST('quantity' . $i);
            assert($product !== null);

            if($product->getDeliverytime() > $deliverytime) {
                $deliverytime = $product->getDeliverytime();
            }

            $order->addProductDescription($product, $productQuantity);
        }
        $order->setDeliverytime($deliverytime);

        $this->orderRepository->add($order);

        return $order;
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Person $loggedInPerson
     * @param int $deliveryTime
     * @param string $productNameList
     * @return void
     */
    private function sendEmail(\MyVendor\SitePackage\Domain\Model\Person $loggedInPerson, int $deliveryTime,
        string $productNameList) : void
    {
        $email = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Mail\MailMessage::class);
        $email->setContentType('text/html');
        $email->setSubject("Delieverrando order");
        $email->setFrom(['order@delieverrando.com' => 'Delieverrando']);
        $email->setTo([$loggedInPerson->getEmail() => $loggedInPerson->getName()]);
        $email->setBody("<h4>You ordered food!</h4><p>It will be delivered in: " . $deliveryTime . " minutes!</p><p>You ordered:</p>" . $productNameList);
        $email->send();
    }

    /**
     * @return void
     */
    public function endOrderAction() : void
    {
        assert($GLOBALS['TSFE']->type === 100);
        assert($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid') !== null);

        $loggedInPerson = $this->personRepository->findByUid($GLOBALS['TSFE']->fe_user->getKey('ses', 'uid'));
        assert($loggedInPerson !== null);

        $order = $this->setupOrderFromPostArguments($loggedInPerson);
        $productDescs = $order->getProductDescriptions();
        $productNameList = '<ul>';
        $quantitySum = 0;
        foreach($productDescs as $productDesc) {
            $product = $productDesc->getProduct();
            $productNameList .= '<li>x' . $productDesc->getQuantity() . ' ' . $product->getName() . '</li>';
            $product->setQuantity($product->getQuantity() - $productDesc->getQuantity());
            if($product->getQuantity() < 0) {
                $this->logger->error('There is/are not enough ' . $product->getName() . '(s) available');
            }
            $this->productRepository->update($productDesc->getProduct());

            $quantitySum += $productDesc->getQuantity();
        }
        $productNameList .= '</ul>';

        $this->sendEmail($loggedInPerson, $order->getDeliverytime(), $productNameList);

        $this->persistAll();

        $this->view->setVariablesToRender(['responseRoot']);
        $this->view->assignMultiple(['responseRoot' => [
            'deliverytime' => $order->getDeliverytime(),
            'orderUid' => $order->getUid(),
            'quantitySum' => $quantitySum,
        ]]);
    }

    public function initializeProgressUpdateAction()
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * @return void
     */
    public function progressUpdateAction() : void
    {
        $orderUid = intval(GeneralUtility::_POST('orderUid'));
        $order = $this->orderRepository->findByUid($orderUid);
        $progress = ['finished'];
        if($order !== null) {
            $progress = $order->getProgress();
        }

        $this->view->setVariablesToRender(['progressRoot']);
        $this->view->assignMultiple(['progressRoot' => [
            'progress' => $progress,
        ]]);
    }
}

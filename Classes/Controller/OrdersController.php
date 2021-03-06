<?php

namespace MyVendor\SitePackage\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class OrdersController extends ActionController
{
    /**
     * @var \MyVendor\SitePackage\Domain\Repository\OrderRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    private $orderRepository;

    /**
     * @return void
     */
    public function indexAction() : void
    {

    }

    public function initializeAjaxAction() : void
    {
        $this->defaultViewObjectName = \TYPO3\CMS\Extbase\Mvc\View\JsonView::class;
    }

    /**
     * @return void
     */
    public function ajaxAction() : void
    {
        assert($GLOBALS['TSFE']->type === 100);

        $this->view->setVariablesToRender(['ordersRoot']);

        $ordersNativeArray = $this->orderRepository->findAll()->toArray();
        $ordersNativeArrayLength = count($ordersNativeArray);
        $ordersJsonArray = [];
        for($i = 0; $i < $ordersNativeArrayLength; ++$i) {
            $it = $ordersNativeArray[$i];
            $person = $it->getPerson();
            $productDescriptions = [];
            $finishLink = GeneralUtility::makeInstance(ObjectManager::class)->get(UriBuilder::class)->setTargetPageUid(10)->setArguments(['tx_sitepackage_bestellungen[action]' => 'finish', 'tx_sitepackage_bestellungen[controller]' => 'Orders', 'tx_sitepackage_bestellungen[order]' => $it->getUid()])->buildFrontendUri();;
            foreach($it->getProductDescriptions() as $productDesc) {
                array_push($productDescriptions, [
                    'productUid' => $productDesc->getProduct()->getUid(),
                    'productName' => $productDesc->getProduct()->getName(),
                    'quantity' => $productDesc->getQuantity(),
                ]);
            }

            array_push($ordersJsonArray, [
                'uid' => $it->getUid(),
                'person' => [
                    'name' => $person->getName(),
                    'address' => $person->getAddress(),
                    'telephonenumber' => $person->getTelephonenumber(),
                ],
                'productDescriptions' => $productDescriptions,
                'finishLink' => $finishLink,
            ]);
        }

        $this->view->assignMultiple(['ordersRoot' => [
            'orders' => $ordersJsonArray,
        ]]);
    }

    /**
     * @return void
     */
    public function updateProgressAction() : void
    {
        assert($GLOBALS['TSFE']->type === 100);

        $order = $this->orderRepository->findByUid(GeneralUtility::_POST('orderUid'));
        $order->alterProgress(GeneralUtility::_POST('productIndex'), GeneralUtility::_POST('checked'));
        $this->orderRepository->update($order);
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Order $order
     * @return void
     */
    public function finishAction(\MyVendor\SitePackage\Domain\Model\Order $order) : void
    {
        $this->orderRepository->remove($order);

        $this->redirect('index');
    }
}
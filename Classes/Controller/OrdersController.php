<?php

namespace MyVendor\SitePackage\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class OrdersController extends ActionController
{
    /**
     * @var \MyVendor\SitePackage\Domain\Repository\OrderRepository
     * @inject
     */
    private $orderRepository;

    /**
     * @return object
     */
    private function getToDisplayOrders() : object
    {
        return $this->orderRepository->findAll();
    }

    /**
     * @return void
     */
    public function indexAction() : void
    {
        $this->view->assign('orders', $this->getToDisplayOrders());
    }

    /**
     * @return void
     */
    public function ajaxAction() : void
    {
        $this->view->assign('orders', $this->getToDisplayOrders());
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
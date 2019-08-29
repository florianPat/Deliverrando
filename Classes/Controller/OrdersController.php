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

    private function getToDisplayOrders()
    {
        return $this->orderRepository->findAll();
    }

    public function indexAction()
    {
        $this->view->assign('orders', $this->getToDisplayOrders());
    }

    public function ajaxAction()
    {
        $this->view->assign('orders', $this->getToDisplayOrders());
    }

    /**
     * @param \MyVendor\SitePackage\Domain\Model\Order $order
     * @return void
     */
    public function finishAction(\MyVendor\SitePackage\Domain\Model\Order $order)
    {
        $this->orderRepository->remove($order);

        $this->redirect('index');
    }
}
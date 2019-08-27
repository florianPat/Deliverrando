<?php

namespace MyVendor\SitePackage\View\Orders;

use TYPO3\CMS\Extbase\Mvc\View\AbstractView;

class AjaxHTML extends AbstractView
{
    public function render()
    {
        assert(isset($this->variables['orders']));
        $orders = $this->variables['orders'];

        $result = '<div class="card-deck">';

        foreach($orders as $order) {
                $result .= '<div class="card">' .
                    '<h2 class="card-header">Order id: ' . $order->getUid() . '</h2>' .
                    '<div class="card-body">' .
                        '<h4 class="card-subtitle">Person</h4>' .
                        '<p class="card-text">Name: ' . $order->getPerson()->getName() . '</p>' .
                        '<p class="card-text">Address: ' . $order->getPerson()->GetName() . '</p>' .
                        '<p class="card-text">Telephone number: ' . $order->getPerson()->getTelephonenumber() . '</p>' .
                        '<br />' .
                        '<div class="card-header">' .
                            'Products' .
                        '</div>' .
                        '<ul class="list-group">';
                            foreach($order->getProducts() as $product) {
                                $result .= '<li class="list-group-item">' . $product->getName() . '</li>';
                            }
                        $result .= '</ul>'.
                    '</div>' .
                    '<div class="card-footer text-muted">' .
                        '<a href="/en/page-1/orderdelieverer?tx_sitepackage_bestellungen[action]=finish&tx_sitepackage_bestellungen[order]=' . $order->getUid() .
                        '" class="card-link">Finished!</a>' .
                    '</div>' .
                '</div>';
        }

        $result .= '</div>';

        return $result;
    }
}
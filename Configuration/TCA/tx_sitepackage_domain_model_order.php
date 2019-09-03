<?php

return [
    'ctrl' => [
        'title' => 'Order',
        'label' => 'name',
    ],
    'columns' => [
        'person' => [
            'label' => 'Person',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_sitepackage_domain_model_person',
            ],
        ],
        'products' => [
            'label' => 'Products',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'size' => '10',
                'minitems' => '1',
                'multiple' => '0',
                'autoSizeMax' => '5',
                'foreign_table' => 'tx_sitepackage_domain_model_product',
                'MM' => 'tx_sitepackage_order_product_mm',
            ],
        ],
        'deliverytime' => [
            'label' => 'Delievery time',
            'config' => [
                'type' => 'input',
                'size' => '3',
                'eval' => 'int',
                'range' => [
                    'lower' => 0,
                    'upper' => 1000,
                ],
            ],
        ],
    ],
    'types' => [
        '0' => ['showitem' => 'person, products, deliverytime'],
    ],
];
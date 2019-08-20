<?php

// So sieht der Table im Backend aus!
return [
  'ctrl' => [
    'title' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product',
    'label' => 'name',
  ],
  'columns' => [
    'name' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.name',
      'config' => [
          'type' => 'input',
          'size' => '20',
          'eval' => 'trim',
      ],
    ],
    'description' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.description',
      'config' => [
        'type' => 'text',
        'eval' => 'trim',
        'max' => '30',
      ],
    ],
    'quantity' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.quantity',
      'config' => [
        'type' => 'input',
        'size' => '4',
        'eval' => 'int',
      ],
    ],
    'delieveryTime' => [
      'label' => 'Delievery time',
      'config' => [
          'type' => 'input',
          'size' => '3',
          'eval' => 'int',
      ],
    ],
    'categories' => [
        'label' => 'Categories',
        'config' => [
            'type' => 'select',
            'size' => '5',
            'minitems' => '0',
            'maxitems' => '5',
            'multiple' => '0',
            'autoSizeMax' => '5',
            'foreign_table' => 'tx_sitepackage_domain_model_category',
            'MM' => 'tx_sitepackage_product_category_mm',
        ],
    ],
  ],
  'types' => [
    '0' => ['showitem' => 'name, description, quantity, delieveryTime, categories'],
  ],
];

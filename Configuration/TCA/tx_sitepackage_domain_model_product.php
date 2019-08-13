<?php

// So sieht der Table im Backend aus!
return [
  'ctrl' => [
    'title' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product',
    'label' => 'name'
  ],
  'columns' => [
    'name' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.name',
      'config' => [
        'type' => 'input',
        'size' => '20',
        'eval' => 'trim'
      ],
    ],
    'description' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.description',
      'config' => [
        'type' => 'text',
        'eval' => 'trim'
      ],
    ],
    'quantity' => [
      'label' => 'LLL:EXT:site_package/Resources/Private/Language/locallang_db.xlf:tx_sitepackage_domain_model_product.quantity',
      'config' => [
        'type' => 'input',
        'size' => '4',
        'eval' => 'int'
      ],
    ],
  ],
  'types' => [
    '0' => ['showitem' => 'name, description, quantity'],
  ],
];

<?php

defined('TYPO3_MODE') || die('Access denied.');

// NOTE: the extension key, the name of the plugin (which is used in GET and POST)(in UpperCamelCase, but lowerCamelCase in GET/POST),
// which action from which controller can be executed,
// and which actions should not be cacheable
// NOTE: Also look into "tt_content"!

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
  'MyVendor.SitePackage',
  'Productlist',
  [
      'StoreInventory' => 'index, add, remove, show, update, login, register, logout, endOrder',
  ],
  [
      'StoreInventory' => 'index, add, remove, show, update, login, register, logout, endOrder',
  ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'MyVendor.SitePackage',
    'Bestellungen',
    [
        'Orders' => 'index, finish, ajax',
    ],
    [
        'Orders' => 'index, finish, ajax',
    ]
);

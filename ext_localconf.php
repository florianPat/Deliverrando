<?php

defined('TYPO3_MODE') || die('Access denied.');

// the extension key, the name of the plugin (which is used in GET and POST)(in UpperCamelCase, but lowerCamelCase in GET/POST),
// which action from which controller can be executed,
// and which actions should not be cacheable

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
  'MyVendor.SitePackage',
  'InventoryList',
  [
    'StoreInventory' => 'index, add, remove, show',
  ],
  [
    'StoreInventory' => 'index, add, remove, show',
  ]
);

<?php

// NOTE: The extension key, the name of the plugin (the one from setupPlugin in ext_localconf.php),
// a label for the plugin

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
  'MyVendor.SitePackage',
  'Productlist',
  'Die Produktliste + Bestellungen'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'MyVendor.SitePackage',
    'Bestellungen',
    'Die Bestellungen der Kunden'
);
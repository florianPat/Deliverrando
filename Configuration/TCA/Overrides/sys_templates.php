<?php
defined('TYPO3_MODE') || die();

(function()
{
  // Dadurch kann man das Template im Backend auswählen
  $extensionKey = 'site_package';

  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
     $extensionKey,
     'Configuration/TypoScript',
     'Sitepackage'
  );

  // ... oder die PageTSConfig
  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
    $extensionKey,
    'Configuration/TSConfig/Test.tsconfig',
    'Test'
  );
})();

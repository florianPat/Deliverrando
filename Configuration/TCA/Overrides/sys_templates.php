<?php
defined('TYPO3_MODE') || die();

(function()
{
    // NOTE: Dadurch kann man das Template im Backend auswählen

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
     'site_package',
     'Configuration/TypoScript/Default',
     'Sitepackage'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'site_package',
        'Configuration/TypoScript/WithoutSchnickSchnack',
        'WithoutSchnickSchnack'
    );
})();

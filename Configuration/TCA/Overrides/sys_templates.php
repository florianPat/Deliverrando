<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

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

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        'site_package',
        'Configuration/TypoScript/Json',
        'Json'
    );

    $sysTemplateRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\MyVendor\SitePackage\Domain\Repository\SysTemplatesRepository::class);
    //TODO: get currently selected page in backend!
    $staticTemplate = $sysTemplateRepository->findIncludeStaticFileByPageUid(12);
    $findResult = strpos($staticTemplate, 'EXT:site_package/Configuration/TypoScript/Json');
    if($findResult !== false) {
        $items = $sysTemplateRepository->findAllTtContentListTypes();

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_template', [
            'plugin_for_template' => [
                'label' => 'Plugin for Template',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => $items,
                ],
            ]
        ]);

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_template', 'plugin_for_template',
            '', 'after:include_static_file');
    }
})();

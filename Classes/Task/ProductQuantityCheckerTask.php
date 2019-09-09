<?php

namespace MyVendor\SitePackage\Task;

use \TYPO3\CMS\Scheduler\Task\AbstractTask;

class ProductQuantityCheckerTask extends AbstractTask
{
    public function execute()
    {
        //NOTE: It is better to do the logic in another class, because the task gets cached and changes do not get reflected.
        $businessLogic = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\MyVendor\SitePackage\Task\ProductQuantityCheckerLogic::class);
        return $businessLogic->run();
    }
}

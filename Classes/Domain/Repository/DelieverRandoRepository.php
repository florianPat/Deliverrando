<?php

namespace MyVendor\SitePackage\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class DelieverRandoRepository extends Repository
{
    /**
     * @param int $userGroup
     * @return array
     */
    public function findProductsByUserGroup($userGroup)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sitepackage_domain_model_delieverRando');

        $statement = $queryBuilder->select('products')->from('tx_sitepackage_domain_model_delieverRando')->where(
            $queryBuilder->expr()->eq('userGroup', $queryBuilder->createNamedParameter($userGroup))
        )->execute();

        return $statement->fetch()['products'];
    }

    /**
     * @param int $userGroup
     * @return string
     */
    public function findUserGroupName($userGroup)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');

        $statement = $queryBuilder->select('title')->from('fe_groups')->where(
            $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($userGroup))
        )->setMaxResults(1)->execute();

        return $statement->fetch()['title'];
    }

    /**
     * @param int $userGroup
     */
    public function findSubGroup($userGroup)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');

        $statement = $queryBuilder->select('subgroup')->from('fe_groups')->where(
            $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($userGroup))
        )->execute();

        $result = $statement->fetch()['subgroup'];

        if($result !== '') {
            return $result;
        }  else {
            return -1;
        }
    }
}
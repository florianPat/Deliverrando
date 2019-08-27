<?php

namespace MyVendor\SitePackage\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

class DelieverrandoRepository extends Repository
{
    /**
     * @param int $userGroup
     * @return string
     */
    public function findDelieverRandoUid($userGroupUid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sitepackage_domain_model_delieverrando');

        $statement = $queryBuilder->select('uid')->from('tx_sitepackage_domain_model_delieverrando')->where(
            $queryBuilder->expr()->eq('userGroup', $queryBuilder->createNamedParameter($userGroupUid))
        )->execute();

        return $statement->fetch()['uid'];
    }

    /**
     * @param int $userGroupUid
     * @return int
     */
    private function findSubGroup($userGroupUid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('fe_groups');

        $statement = $queryBuilder->select('subgroup')->from('fe_groups')->where(
            $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($userGroupUid))
        )->execute();

        $result = $statement->fetch()['subgroup'];

        if($result !== '') {
            return $result;
        }  else {
            return -1;
        }
    }

    public function findDelieverRandoName($uid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sitepackage_domain_model_delieverrando');

        $statement = $queryBuilder->select('name')->from('tx_sitepackage_domain_model_delieverrando')->where(
            $queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid))
        )->execute();

        return $statement->fetch()['name'];
    }

    /**
     * @param int $userGroupUid
     * @return array
     */
    public function findDelieverRandoUidsForUserGroup($userGroupUid)
    {
        $delieverrandoSubGroupIds = [];
        $result = [$this->findDelieverRandoUid($userGroupUid)];

        for($subGroup = $this->findSubGroup($userGroupUid);
            $subGroup != -1;
            $subGroup = $this->findSubGroup($subGroup)) {
            array_push($delieverrandoSubGroupIds, $subGroup);
        }
        foreach($delieverrandoSubGroupIds as $it) {
            array_push($result, $this->findDelieverRandoUid($it));
        }

        return $result;
    }
}
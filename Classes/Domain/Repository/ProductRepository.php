<?php

namespace MyVendor\SitePackage\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Database\ConnectionPool;

/**
 *  @package MyVendor\SitePackage\Domain\Repository
 */
class ProductRepository extends Repository
{
    /**
     * @param string $name
     * @return array
     */
    public function findByName($name)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_sitepackage_domain_model_product');

        $statement = $queryBuilder->select('*')->from('tx_sitepackage_domain_model_product')->where(
            //The first argument is sanity check automatically
            $queryBuilder->expr()->eq('name', $queryBuilder->createNamedParameter($name, \PDO::PARAM_STR))
        )->setMaxResults(1)->execute();

        $rows = $statement->fetchAll();
        assert(count($rows) == 1);
        return $rows[0];
    }

    /**
     * @param string $uids
     * @return array
     */
    public function findByUids($uids)
    {
        $uidArray = explode(',', $uids);

        $result = [];

        foreach($uidArray as $uid) {
            array_push($result, $this->findByUid($uid));
        }

        return $result;
    }
}

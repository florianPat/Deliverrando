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
     * @param array $uids
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllWithDieverRandoUids($uids)
    {
        $query = $this->createQuery();
        $query->matching($query->in('delieverrando', $uids));
        return $query->execute();
    }
}

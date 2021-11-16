<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Ivoz\Core\Infrastructure\Domain\Service\DoctrineQueryRunner;
use Ivoz\Provider\Domain\Model\BillableCallHistoric\BillableCallHistoric;
use Ivoz\Provider\Domain\Model\BillableCallHistoric\BillableCallHistoricRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * BillableCallHistoricDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<BillableCallHistoric>
 */
class BillableCallHistoricDoctrineRepository extends ServiceEntityRepository implements BillableCallHistoricRepository
{
    private $queryRunner;

    public function __construct(
        ManagerRegistry $registry,
        DoctrineQueryRunner $queryRunner
    ) {
        parent::__construct($registry, BillableCallHistoric::class);
        $this->queryRunner = $queryRunner;
    }

    public function copyBillableCallsByIds(array $ids): int
    {
        $syncSql = sprintf(
            'INSERT INTO BillableCallHistorics SELECT * FROM BillableCalls'
            . ' WHERE id IN (%s)',
            implode(',', $ids)
        );

        $affectedRows = $this->queryRunner->execute(
            BillableCallHistoric::class,
            (new NativeQuery($this->_em))->setSQL($syncSql)
        );

        return $affectedRows;
    }

    public function getMaxId(): int
    {
        $query =
            'SELECT MAX(BH.id) FROM '
            . BillableCallHistoric::class
            . ' BH';

        try {
            $fromId = (new Query($this->_em))
                ->setDQL($query)
                ->getSingleScalarResult();
        } catch (NoResultException) {
        }

        return $fromId ?? 0;
    }
}

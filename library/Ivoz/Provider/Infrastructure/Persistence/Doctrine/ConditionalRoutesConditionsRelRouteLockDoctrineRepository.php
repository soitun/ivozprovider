<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelRouteLock\ConditionalRoutesConditionsRelRouteLock;
use Ivoz\Provider\Domain\Model\ConditionalRoutesConditionsRelRouteLock\ConditionalRoutesConditionsRelRouteLockRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * ConditionalRoutesConditionsRelRouteLockDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<ConditionalRoutesConditionsRelRouteLock>
 */
class ConditionalRoutesConditionsRelRouteLockDoctrineRepository extends ServiceEntityRepository implements ConditionalRoutesConditionsRelRouteLockRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConditionalRoutesConditionsRelRouteLock::class);
    }
}

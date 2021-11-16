<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern\RoutingPatternGroupsRelPattern;
use Ivoz\Provider\Domain\Model\RoutingPatternGroupsRelPattern\RoutingPatternGroupsRelPatternRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * RoutingPatternGroupsRelPatternDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @template-extends ServiceEntityRepository<RoutingPatternGroupsRelPattern>
 */
class RoutingPatternGroupsRelPatternDoctrineRepository extends ServiceEntityRepository implements RoutingPatternGroupsRelPatternRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoutingPatternGroupsRelPattern::class);
    }
}

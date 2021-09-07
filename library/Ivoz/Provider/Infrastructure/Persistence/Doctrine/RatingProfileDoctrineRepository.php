<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\RatingProfile\RatingProfile;
use Ivoz\Provider\Domain\Model\RatingProfile\RatingProfileRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * RatingProfileDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RatingProfileDoctrineRepository extends ServiceEntityRepository implements RatingProfileRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RatingProfile::class);
    }

    /**
     * Used by client API access controls
     * @return int[]
     */
    public function getRatingPlanGroupIdsByCompany(int $companyId): array
    {
        $qb = $this->createQueryBuilder('self');
        $expression = $qb->expr();

        $qb
            ->select('IDENTITY(self.ratingPlanGroup) AS ratingPlanGroup')
            ->where(
                $expression->eq('self.company', $companyId)
            );

        $result = $qb->getQuery()->getScalarResult();

        return array_map(
            'intval',
            array_column($result, 'ratingPlanGroup')
        );
    }
}

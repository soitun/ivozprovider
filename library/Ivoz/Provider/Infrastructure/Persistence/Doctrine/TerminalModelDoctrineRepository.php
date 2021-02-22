<?php

namespace Ivoz\Provider\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Ivoz\Provider\Domain\Model\TerminalModel\TerminalModel;
use Ivoz\Provider\Domain\Model\TerminalModel\TerminalModelInterface;
use Ivoz\Provider\Domain\Model\TerminalModel\TerminalModelRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * TerminalModelDoctrineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TerminalModelDoctrineRepository extends ServiceEntityRepository implements TerminalModelRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TerminalModel::class);
    }

    /**
     * @return TerminalModelInterface | null
     */
    public function findOneByIden(string $iden)
    {
        /** @var TerminalModelInterface $response */
        $response = $this->findOneBy([
            'iden' => $iden
        ]);

        return $response;
    }
}

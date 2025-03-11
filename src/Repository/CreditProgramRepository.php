<?php

namespace App\Repository;

use App\Entity\CreditProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditProgram>
 */
class CreditProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
    }

    public function findBestProgram(float $initialPayment, int $loanTerm): ?CreditProgram
    {
        $queryBuilder = $this->createQueryBuilder('program')
            ->setParameter('initialPayment', $initialPayment)
            ->setParameter('loanTerm', $loanTerm);

        return $queryBuilder
            ->where($queryBuilder->expr()->lte('program.minInitialPayment', ':initialPayment'))
            ->andWhere($queryBuilder->expr()->gte('program.maxLoanTerm', ':loanTerm'))
            ->orderBy('program.interestRate')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

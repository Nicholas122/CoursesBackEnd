<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * TestResultRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TestResultRepository extends \Doctrine\ORM\EntityRepository
{
    public function viewTestResult(User $user)
    {
        $qb = $this->createQueryBuilder('entity');

        $qb->update('AppBundle:TestResult', 'entity')
            ->set('entity.viewed', 1)
            ->where($qb->expr()->eq('entity.user', $user->getId()))
            ->andWhere($qb->expr()->eq('entity.checked', 1))
            ->andWhere($qb->expr()->isNull('entity.viewed'))->getQuery()->execute();


    }
}
<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * The user repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findByYear($year)
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('u')
            ->from($this->_entityName, 'u', 'u.id')
            ->where($builder->expr()->lte('u.created', ':year'))
            ->setParameter(':year', $year.'-01-01')
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }
}

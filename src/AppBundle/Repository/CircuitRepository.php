<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Circuit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class CircuitRepository extends EntityRepository implements CircuitRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findBySlugs(array $slugs): Collection
    {
        $builder = $this->_em->createQueryBuilder();
        $builder
            ->select('c')
            ->from($this->_entityName, 'c', 'c.slug')
            ->where($builder->expr()->in('c.slug', ':slugs'))
            ->setParameter(':slugs', $slugs)
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function save(Circuit $circuit)
    {
        $this->_em->persist($circuit);
        $this->_em->flush();
    }
}

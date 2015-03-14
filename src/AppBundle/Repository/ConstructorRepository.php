<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The constructor repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorRepository extends EntityRepository implements ConstructorRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function findBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlugs(array $slugs)
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
}

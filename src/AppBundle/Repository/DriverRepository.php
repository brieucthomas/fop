<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Driver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * The driver repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverRepository extends EntityRepository implements DriverRepositoryInterface
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
            ->select('d')
            ->from($this->_entityName, 'd', 'd.slug')
            ->where($builder->expr()->in('d.slug', ':slugs'))
            ->setParameter(':slugs', $slugs)
        ;

        return new ArrayCollection($builder->getQuery()->getResult());
    }

    /**
     * {@inheritdoc}
     */
    public function save(Driver $driver)
    {
        $this->_em->persist($driver);
        $this->_em->flush();
    }
}

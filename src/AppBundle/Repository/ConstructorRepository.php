<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
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
    public function save(Constructor $constructor)
    {
        $this->_em->persist($constructor);
        $this->_em->flush();
    }
}

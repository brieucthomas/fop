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

/**
 * The Constructor repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorRepositoryInterface
{
    /**
     * Finds constructors by slugs.
     *
     * @param array $slugs An array of constructor slugs
     *
     * @return ArrayCollection A collection of Constructor entities indexed by slug
     */
    public function findBySlugs(array $slugs);
}

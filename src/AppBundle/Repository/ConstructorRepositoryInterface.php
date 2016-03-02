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
use Doctrine\Common\Collections\Collection;

/**
 * The constructor repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorRepositoryInterface
{
    /**
     * Finds constructor by its slug.
     *
     * @param string $slug A constructor slug
     *
     * @return Constructor|null A Constructor entity or null if not found
     */
    public function findBySlug($slug);

    /**
     * Finds constructors by slugs.
     *
     * @param array $slugs An array of constructor slugs
     *
     * @return Collection A collection of Constructor entities indexed by slug
     */
    public function findBySlugs(array $slugs) : Collection;
}

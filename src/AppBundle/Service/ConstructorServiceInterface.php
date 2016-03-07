<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Constructor;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface ConstructorServiceInterface
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
     * Saves a constructor.
     *
     * @param Constructor $constructor The constructor to save
     */
    public function save(Constructor $constructor);
}

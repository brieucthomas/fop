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

/**
 * The driver repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface DriverRepositoryInterface
{
    /**
     * Finds driver by its slug.
     *
     * @param string $slug The driver slug
     *
     * @return Driver|null The Driver entity or null if not found
     */
    public function findBySlug($slug);

    /**
     * Finds drivers by slugs.
     *
     * @param array $slugs An array of driver slugs
     *
     * @return ArrayCollection A collection of Driver entities indexed by slug
     */
    public function findBySlugs(array $slugs);

    /**
     * Saves a driver.
     *
     * @param Driver $driver The driver to save
     */
    public function save(Driver $driver);
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The Driver service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface DriverServiceInterface
{
    /**
     * Finds drivers by slugs.
     *
     * @param array $slugs An array of driver slugs
     *
     * @return ArrayCollection A collection of Driver entities indexed by slug
     */
    public function findBySlugs(array $slugs);
}

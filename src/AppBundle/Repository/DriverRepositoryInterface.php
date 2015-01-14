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
 * The Driver repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface DriverRepositoryInterface
{
    /**
     * Finds drivers by identifiers.
     *
     * @param array $ids An array of driver identifiers
     *
     * @return ArrayCollection A collection of Driver entities indexed by id
     */
    public function findByIds(array $ids);
}

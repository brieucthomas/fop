<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

/**
 * The Team repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface TeamRepositoryInterface
{
    /**
     * Returns the teams by the given year.
     *
     * @param int $year A year
     *
     * @return QueryBuilder
     */
    public function findByYear($year);

    /**
     * Returns the teams of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return ArrayCollection A collection of Team entities
     */
    public function findByDriver($driverId);
}

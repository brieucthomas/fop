<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Constructor;
use AppBundle\Entity\Driver;
use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\QueryBuilder;

/**
 * The team repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface TeamRepositoryInterface
{
    public function findBySeasonAndDriverAndConstructor(Season $season, Driver $driver, Constructor $constructor);
    
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

    /**
     * Saves a team.
     *
     * @param Team $team The team to save
     */
    public function save(Team $team);
}

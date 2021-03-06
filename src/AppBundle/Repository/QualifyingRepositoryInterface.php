<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Qualifying;
use AppBundle\Entity\Season;

/**
 * The qualifying repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface QualifyingRepositoryInterface
{
    /**
     * Saves a qualifying.
     *
     * @param Qualifying $qualifying The qualifying to save
     */
    public function save(Qualifying $qualifying);

    /**
     * Returns the number of pole positions of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The number of pole positions
     */
    public function countPolePositionsByDriver($driverId);

    /**
     * Returns the best grid position of a driver.
     *
     * @param string $driverId A driver identifier
     *
     * @return int The best grid position
     */
    public function getBestGridByDriver($driverId);

    /**
     * Removes qualifying by season.
     *
     * @param Season $season A Season entity
     */
    public function removeBySeason(Season $season);
}

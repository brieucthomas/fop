<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Driver;
use AppBundle\Entity\Qualifying;

/**
 * The qualifying service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface QualifyingServiceInterface
{
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
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Team;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface TeamServiceInterface
{
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

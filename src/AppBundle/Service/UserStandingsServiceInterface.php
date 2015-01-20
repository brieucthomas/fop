<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Entity\Season;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The user standings service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface UserStandingsServiceInterface
{
    /**
     * Removes by season.
     *
     * @param Season $season A Season entity
     *
     * @return $this
     */
    public function removeBySeason(Season $season);
}

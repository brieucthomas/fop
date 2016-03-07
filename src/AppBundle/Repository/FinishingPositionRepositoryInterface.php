<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Season;

/**
 * The finishing position repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface FinishingPositionRepositoryInterface
{
    /**
     * Updates a season predictions finishing positions.
     *
     * @param int $year A season year in 4 digits
     */
    public function updateFinishingPositionsByYear($year);
}

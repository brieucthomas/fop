<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * The user repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface UserRepositoryInterface
{
    /**
     * Returns the a season players.
     *
     * @param int $year The season year
     *
     * @return ArrayCollection A collection of User entities
     */
    public function findByYear($year);
}

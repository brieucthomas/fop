<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\Season;
use AppBundle\Entity\User;

/**
 * The prediction service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface PredictionServiceInterface
{
    /**
     * Finds a prediction by a race and user.
     *
     * @param Race $race A Race entity
     * @param User $user A User entity
     *
     * @return Prediction|null The Prediction entity or null if not found
     */
    public function findByRaceAndUser(Race $race, User $user);

    /**
     * Saves a prediction.
     *
     * @param Prediction $prediction A Prediction entity
     *
     * @return $this
     */
    public function save(Prediction $prediction);

    /**
     * Computes season predictions scores.
     *
     * @param Season $season
     *
     * @return $this
     */
    public function computeBySeason(Season $season);
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Entity\User;

/**
 * The prediction repository.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface PredictionRepositoryInterface
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
     * Removes a prediction.
     *
     * @param Prediction $prediction A prediction entity
     */
    public function remove(Prediction $prediction);

    /**
     * Saves a prediction.
     *
     * @param Prediction $prediction A Prediction entity
     */
    public function save(Prediction $prediction);
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Season;

/**
 * The prediction service.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
interface PredictionServiceInterface
{
    /**
     * Computes season predictions scores.
     *
     * @param Season $season
     *
     * @return $this
     */
    public function computeBySeason(Season $season);
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\UserStandings;

/**
 * Injects user standings information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserStandingsProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['userStandings'])) {
            return $record;
        }

        $userStandings = $record['context']['userStandings'];

        if (!$userStandings instanceof UserStandings) {
            return $record;
        }

        $record['context']['userStandings'] = [
            'season' => $userStandings->getRace()->getSeason()->getYear(),
            'round' => $userStandings->getRace()->getRound(),
            'position' => $userStandings->getPosition(),
            'user' => $userStandings->getUser()->getSlug(),
            'points' => $userStandings->getPoints(),
        ];

        return $record;
    }
}

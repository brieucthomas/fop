<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Team;

/**
 * Injects team information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class TeamProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['team'])) {
            return $record;
        }

        $team = $record['context']['team'];

        if (!$team instanceof Team) {
            return $record;
        }

        $record['context']['team'] = [
            'id' => $team->getId(),
            'season' => $team->getSeason()->getYear(),
            'driver' => $team->getDriver()->getSlug(),
            'constructor' => $team->getConstructor()->getSlug(),
        ];

        return $record;
    }
}

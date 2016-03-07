<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Race;

/**
 * Injects race information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class RaceProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['race'])) {
            return $record;
        }

        $race = $record['context']['race'];

        if (!$race instanceof Race) {
            return $record;
        }

        $record['context']['race'] = [
            'id' => $race->getId(),
            'season' => $race->getSeason()->getYear(),
            'round' => $race->getRound(),
            'name' => $race->getName(),
        ];

        return $record;
    }
}

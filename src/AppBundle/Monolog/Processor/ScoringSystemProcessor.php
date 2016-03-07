<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\ScoringSystem;

/**
 * Injects scoring system information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ScoringSystemProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['scoringSystem'])) {
            return $record;
        }

        $scoringSystem = $record['context']['scoringSystem'];

        if (!$scoringSystem instanceof ScoringSystem) {
            return $record;
        }

        $record['context']['scoringSystem'] = [
            'id' => $scoringSystem->getId(),
            'name' => $scoringSystem->getName(),
        ];

        return $record;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Result;

/**
 * Injects result information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ResultProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['result'])) {
            return $record;
        }

        $result = $record['context']['result'];

        if (!$result instanceof Result) {
            return $record;
        }

        $record['context']['result'] = [
            'season' => $result->getRace()->getSeason()->getYear(),
            'round' => $result->getRace()->getRound(),
            'position' => $result->getPosition()
        ];

        return $record;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\FinishingStatus;

/**
 * Injects finishing status information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatusProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['finishingStatus'])) {
            return $record;
        }

        $finishingStatus = $record['context']['finishingStatus'];

        if (!$finishingStatus instanceof FinishingStatus) {
            return $record;
        }

        $record['context']['finishingStatus'] = [
            'id' => $finishingStatus->getId(),
            'slug' => $finishingStatus->getLabel(),
        ];

        return $record;
    }
}

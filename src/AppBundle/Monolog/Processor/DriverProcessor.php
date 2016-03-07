<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Monolog\Processor;

use AppBundle\Entity\Driver;

/**
 * Injects driver information into records.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverProcessor
{
    public function __invoke(array $record)
    {
        if (!isset($record['context']['driver'])) {
            return $record;
        }

        $driver = $record['context']['driver'];

        if (!$driver instanceof Driver) {
            return $record;
        }

        $record['context']['driver'] = [
            'id' => $driver->getId(),
            'slug' => $driver->getSlug(),
        ];

        return $record;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Heroku;

use Composer\Script\Event;

/**
 * Sets database parameters.
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Database
{
    public static function populateEnvironment(Event $event)
    {
        $url = getenv("DATABASE_URL");

        if ($url) {
            $url = parse_url($url);
            putenv("DATABASE_HOST={$url['host']}");
            putenv("DATABASE_USER={$url['user']}");
            putenv("DATABASE_PASSWORD={$url['pass']}");
            $db = substr($url['path'], 1);
            putenv("DATABASE_NAME={$db}");
        }

        $io = $event->getIO();

        $io->write("DATABASE_URL=" . getenv("DATABASE_URL"));
    }
}
<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $this
            ->visit($url)
            ->isOk()
        ;
    }

    public function urlProvider()
    {
        return [
            ['/en/'],
            ['/en/constructors/ferrari'],
            ['/en/drivers/hamilton'],
            ['/en/users/user1'],
            ['/en/races/2014/1'],
            ['/en/seasons/2014/races'],
            ['/en/seasons/2014/teams'],
            ['/en/seasons/2014/graphs'],
            ['/en/seasons/2014/standings/driver'],
            ['/en/seasons/2014/standings/constructor'],
            ['/en/seasons/2014/standings/user'],
        ];
    }
}

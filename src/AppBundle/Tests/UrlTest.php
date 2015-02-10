<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests;

class UrlTest extends WebTestCase
{
    /**
     * @dataProvider provideSuccessUrls
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isOk());
    }

    public function provideSuccessUrls()
    {
        return [
            ['/en/'],
            ['/en/constructors/ferrari'],
            ['/en/drivers/hamilton'],
            ['/en/users/user1'],
            ['/en/races/2014/1'],
            ['/en/seasons/2014'],
            ['/en/seasons/2014/races'],
            ['/en/seasons/2014/teams'],
            ['/en/seasons/2014/standings'],
            ['/en/seasons/2014/graphs'],
        ];
    }
}

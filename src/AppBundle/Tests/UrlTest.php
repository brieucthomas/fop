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

    /**
     * @dataProvider provideNotFoundUrls
     */
    public function testPageIsNotFound($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function provideSuccessUrls()
    {
        return [
            ['/en/'],
            ['/en/constructors/ferrari'],
            ['/en/drivers/hamilton'],
            ['/en/users/user1'],
        ];
    }

    public function provideNotFoundUrls()
    {
        return [
            ['/ru/'],
            ['/en/constructors/foo'],
            ['/en/drivers/foo'],
            ['/en/users/foo'],
        ];
    }
}

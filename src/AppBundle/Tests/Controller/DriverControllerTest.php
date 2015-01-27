<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

class DriverControllerTest extends WebTestCase
{
    public function testShow()
    {
        $crawler = $this->client->request('GET', '/en/drivers/hamilton');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Lewis Hamilton', $crawler->filter('h1')->eq(0)->text());
    }
}

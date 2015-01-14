<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testShow()
    {
        $crawler = $this->client->request('GET', '/en/users/foo');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('foo', $crawler->filter('h1')->eq(0)->text());
    }

    public function testIndex()
    {
        $this->client->request('GET', '/en/users/unknown');
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}

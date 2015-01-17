<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

class ConstructorControllerTest extends WebTestCase
{
    public function testShow()
    {
        $crawler = $this->client->request('GET', '/en/constructors/ferrari');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Ferrari', $crawler->filter('h1')->eq(0)->text());
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\WebTestCase;

class RaceControllerTest extends WebTestCase
{
    public function testShow()
    {
        $year = date('Y') - 1;
        $crawler = $this->client->request('GET', '/fr/races/' . $year . '/1');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame($year . ' Australian Grand Prix', $crawler->filter('h1')->eq(0)->text());
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase as LiipTest;
use Symfony\Bundle\FrameworkBundle\Client;

class WebTestCase extends LiipTest
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();

        $this->loadFixtures([
            'AppBundle\Tests\Fixtures\LoadUserData',
        ]);
    }

    protected function tearDown()
    {
        $this->client = null;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests;

use AppBundle\Service\SeasonServiceInterface;
use AppBundle\Service\UserServiceInterface;
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
            'AppBundle\Tests\FixtureLoader',
        ]);
    }

    protected function tearDown()
    {
        $this->client = null;
    }

    protected function get($service)
    {
        return $this->getContainer()->get($service);
    }

    /**
     * @return SeasonServiceInterface
     */
    protected function getSeasonService()
    {
        return $this->get('season_service');
    }

    /**
     * @return UserServiceInterface
     */
    protected function getUserService()
    {
        return $this->get('user_service');
    }
}

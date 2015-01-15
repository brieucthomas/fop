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
            'AppBundle\Tests\Fixtures\LoadScoringSystemData',
            'AppBundle\Tests\Fixtures\LoadSeasonData',
            'AppBundle\Tests\Fixtures\LoadCircuitData',
            'AppBundle\Tests\Fixtures\LoadDriverData',
            'AppBundle\Tests\Fixtures\LoadConstructorData',
            'AppBundle\Tests\Fixtures\LoadTeamData',
            'AppBundle\Tests\Fixtures\LoadRaceData',
            'AppBundle\Tests\Fixtures\LoadFinishingStatusData',
            'AppBundle\Tests\Fixtures\LoadResultData',
            'AppBundle\Tests\Fixtures\LoadUserData',
            'AppBundle\Tests\Fixtures\LoadPredictionData',
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
}

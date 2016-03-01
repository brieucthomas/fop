<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AppBundle\Service;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Service\PredictionServiceInterface;
use Tests\AppBundle\WebTestCase;

class PredictionServiceTest extends WebTestCase
{
    public function testComputeScoresBySeason()
    {
        $season = $this->get('app.service.season')->findByYear(2013);

        /* @var $race Race */
        $race = $season->getRaces()->first();

        $this->assertCount(10, $race->getUserStandings());

        /* @var $prediction Prediction */
        $prediction = $race->getPredictions()->first();

        $this->assertSame('user_2', $prediction->getUser()->getUsername());
        $this->assertSame(1, $prediction->getPosition());
        $this->assertSame(146, $prediction->getPoints());

        $this->get('app.service.prediction')->computeBySeason($season);

        $this->assertCount(10, $race->getUserStandings());
        $this->assertSame('user_2', $race->getUserStandings()->first()->getUser()->getUsername());
        $this->assertSame(1, $race->getUserStandings()->first()->getWins());
        $this->assertEquals(146, $race->getUserStandings()->first()->getPoints());

        $this->assertSame(1, $prediction->getPosition());
        $this->assertSame(146, $prediction->getPoints());
    }
}

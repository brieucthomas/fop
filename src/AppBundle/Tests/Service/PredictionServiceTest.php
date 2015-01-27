<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Service;

use AppBundle\Entity\Prediction;
use AppBundle\Entity\Race;
use AppBundle\Service\PredictionServiceInterface;
use AppBundle\Tests\WebTestCase;

class PredictionServiceTest extends WebTestCase
{
    public function testComputeScoresBySeason()
    {
        $season = $this->getSeasonService()->findByYear(date('Y') - 1);

        /* @var $race Race */
        $race = $season->getRaces()->first();

        $this->assertCount(0, $race->getUserStandings());

        /* @var $prediction Prediction */
        $prediction = $race->getPredictions()->first();

        $this->assertSame('foo', $prediction->getUser()->getUsername());
        $this->assertSame(0, $prediction->getPosition());
        $this->assertSame(0, $prediction->getPoints());

        $this->getPredictionService()->computeBySeason($season);

        $this->assertCount(1, $race->getUserStandings());
        $this->assertSame('foo', $race->getUserStandings()->first()->getUser()->getUsername());
        $this->assertSame(1, $race->getUserStandings()->first()->getWins());
        $this->assertSame(6.0, $race->getUserStandings()->first()->getPoints());

        $this->assertSame(1, $prediction->getPosition());
        $this->assertSame(6, $prediction->getPoints());
    }

    /**
     * @return PredictionServiceInterface
     */
    private function getPredictionService()
    {
        return $this->get('prediction_service');
    }
}

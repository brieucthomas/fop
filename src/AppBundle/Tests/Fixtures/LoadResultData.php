<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Race;
use AppBundle\Entity\Result;
use AppBundle\Entity\Team;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadResultData extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this
            ->loadPreviousSeasonResults()
            ->loadCurrentSeasonResults()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Tests\Fixtures\LoadRaceData',
            'AppBundle\Tests\Fixtures\LoadFinishingStatusData',
        ];
    }

    private function loadPreviousSeasonResults()
    {
        $result1 = new Result();
        $result1
            ->setPosition(1)
            ->setTeam($this->getReference('team-previous-mercedes-rosberg'))
            ->setFinishingStatus($this->getReference('finishing-status-finished'))
            ->setPoints(25)
            ->setGrid(3)
            ->setTime('1:32:58.710')
            ->setLaps(57)
            ->setFastestLap(19)
            ->setFastestLapRank(1)
            ->setFastestLapSpeed(206.436)
            ->setFastestLapTime('1:32.478')
        ;

        $result2 = new Result();
        $result2
            ->setPosition(2)
            ->setTeam($this->getReference('team-previous-mclaren-magnussen'))
            ->setFinishingStatus($this->getReference('finishing-status-finished'))
            ->setPoints(18)
            ->setGrid(4)
            ->setTime('+26.777')
            ->setLaps(57)
            ->setFastestLap(48)
            ->setFastestLapRank(6)
            ->setFastestLapSpeed(205.131)
            ->setFastestLapTime('1:33.066')
        ;

        $result3 = new Result();
        $result3
            ->setPosition(3)
            ->setTeam($this->getReference('team-previous-mclaren-button'))
            ->setFinishingStatus($this->getReference('finishing-status-finished'))
            ->setPoints(15)
            ->setGrid(10)
            ->setTime('+30.027')
            ->setLaps(57)
            ->setFastestLap(39)
            ->setFastestLapRank(5)
            ->setFastestLapSpeed(205.460)
            ->setFastestLapTime('1:32.917')
        ;

        /* @var $race1 Race */
        $race1 = $this->getReference('race-previous-1');
        $race1
            ->addResult($result1)
            ->addResult($result2)
            ->addResult($result3)
        ;

        $this->manager->persist($race1);
        $this->manager->flush();

        return $this;
    }

    private function loadCurrentSeasonResults()
    {
        return $this;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Circuit;
use AppBundle\Entity\Race;
use AppBundle\Entity\Season;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRaceData extends AbstractFixture implements DependentFixtureInterface
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
            ->loadPreviousSeasonRaces()
            ->loadCurrentSeasonRaces()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Tests\Fixtures\LoadSeasonData',
            'AppBundle\Tests\Fixtures\LoadCircuitData',
        ];
    }

    private function loadPreviousSeasonRaces()
    {
        /* @var $season Season */
        $season = $this->getReference('season-previous');

        $date = new \DateTime();

        $race1 = new Race();
        $race1
            ->setCircuit($this->getReference('circuit-albert-park'))
            ->setName('Australian Grand Prix')
            ->setRound(1)
            ->setDate($this->createDateTime($season, 3, 16, 6))
        ;

        $race2 = new Race();
        $race2
            ->setCircuit($this->getReference('circuit-catalunya'))
            ->setName('Spanish Grand Prix')
            ->setRound(2)
            ->setDate($this->createDateTime($season, 5, 11, 12))
        ;

        $race3 = new Race();
        $race3
            ->setCircuit($this->getReference('circuit-monaco'))
            ->setName('Monaco Grand Prix')
            ->setRound(3)
            ->setDate($this->createDateTime($season, 5, 25, 12))
        ;

        $race4 = new Race();
        $race4
            ->setCircuit($this->getReference('circuit-spa'))
            ->setName('Belgian Grand Prix')
            ->setRound(4)
            ->setDate($this->createDateTime($season, 8, 24, 12))
        ;

        $this->addReference('race-previous-1', $race1);
        $this->addReference('race-previous-2', $race2);
        $this->addReference('race-previous-3', $race3);
        $this->addReference('race-previous-4', $race4);

        $season
            ->addRace($race3)
            ->addRace($race1)
            ->addRace($race4)
            ->addRace($race2)
        ;

        $this->manager->persist($season);
        $this->manager->flush();

        return $this;
    }

    private function loadCurrentSeasonRaces()
    {
        return $this;
    }

    private function createDateTime(Season $season, $month, $day, $hour)
    {
        return new \DateTime(sprintf('%s-%s-%s %s:00:00', $season->getYear(), $month, $day, $hour));
    }
}

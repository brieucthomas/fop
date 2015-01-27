<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Tests\Fixtures;

use AppBundle\Entity\Season;
use AppBundle\Entity\Team;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTeamData extends AbstractFixture implements DependentFixtureInterface
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
            ->loadPreviousSeasonTeams()
            ->loadCurrentSeasonTeams()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [
            'AppBundle\Tests\Fixtures\LoadSeasonData',
            'AppBundle\Tests\Fixtures\LoadDriverData',
            'AppBundle\Tests\Fixtures\LoadConstructorData'
        ];
    }

    private function loadPreviousSeasonTeams()
    {
        /* @var $season Season */
        $season = $this->getReference('season-previous');

        $team1 = new Team($this->getReference('constructor-ferrari'), $this->getReference('driver-alonso'));
        $team2 = new Team($this->getReference('constructor-ferrari'), $this->getReference('driver-raikkonen'));
        $team3 = new Team($this->getReference('constructor-mercedes'), $this->getReference('driver-hamilton'));
        $team4 = new Team($this->getReference('constructor-mercedes'), $this->getReference('driver-rosberg'));
        $team5 = new Team($this->getReference('constructor-redbull'), $this->getReference('driver-vettel'));
        $team6 = new Team($this->getReference('constructor-redbull'), $this->getReference('driver-ricciardo'));
        $team7 = new Team($this->getReference('constructor-mclaren'), $this->getReference('driver-button'));
        $team8 = new Team($this->getReference('constructor-mclaren'), $this->getReference('driver-magnussen'));

        $this->addReference('team-previous-ferrari-alonso', $team1);
        $this->addReference('team-previous-ferrari-raikkonen', $team2);
        $this->addReference('team-previous-mercedes-hamilton', $team3);
        $this->addReference('team-previous-mercedes-rosberg', $team4);
        $this->addReference('team-previous-redbull-vettel', $team5);
        $this->addReference('team-previous-redbull-ricciardo', $team6);
        $this->addReference('team-previous-mclaren-button', $team7);
        $this->addReference('team-previous-mclaren-magnussen', $team8);

        $season
            ->addTeam($team1)
            ->addTeam($team2)
            ->addTeam($team3)
            ->addTeam($team4)
            ->addTeam($team5)
            ->addTeam($team6)
            ->addTeam($team7)
            ->addTeam($team8)
        ;

        $this->manager->persist($season);
        $this->manager->flush();

        return $this;
    }

    private function loadCurrentSeasonTeams()
    {
        /* @var $season Season */
        $season = $this->getReference('season-current');

        $team1 = new Team($this->getReference('constructor-ferrari'), $this->getReference('driver-raikkonen'));
        $team2 = new Team($this->getReference('constructor-ferrari'), $this->getReference('driver-vettel'));
        $team3 = new Team($this->getReference('constructor-mercedes'), $this->getReference('driver-hamilton'));
        $team4 = new Team($this->getReference('constructor-mercedes'), $this->getReference('driver-rosberg'));
        $team5 = new Team($this->getReference('constructor-redbull'), $this->getReference('driver-ricciardo'));
        $team6 = new Team($this->getReference('constructor-redbull'), $this->getReference('driver-kvyat'));
        $team7 = new Team($this->getReference('constructor-mclaren'), $this->getReference('driver-alonso'));
        $team8 = new Team($this->getReference('constructor-mclaren'), $this->getReference('driver-button'));

        $this->addReference('team-current-ferrari-raikkonen', $team1);
        $this->addReference('team-current-ferrari-vettel', $team2);
        $this->addReference('team-current-mercedes-hamilton', $team3);
        $this->addReference('team-current-mercedes-rosberg', $team4);
        $this->addReference('team-current-redbull-ricciardo', $team5);
        $this->addReference('team-current-redbull-kvyat', $team6);
        $this->addReference('team-current-mclaren-alonso', $team7);
        $this->addReference('team-current-mclaren-button', $team8);

        $season
            ->addTeam($team1)
            ->addTeam($team2)
            ->addTeam($team3)
            ->addTeam($team4)
            ->addTeam($team5)
            ->addTeam($team6)
            ->addTeam($team7)
            ->addTeam($team8)
        ;

        $this->manager->persist($season);
        $this->manager->flush();

        return $this;
    }
}

<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The season entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeasonRepository")
 * @ORM\Table
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Season
{
    /**
     * The season year.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Regex("/^[0-9]{4}$/")
     * @Assert\GreaterThanOrEqual(value="1950")
     *
     * @var int
     */
    protected $year;

    /**
     * The season races.
     *
     * @ORM\OneToMany(
     *      targetEntity="Race",
     *      mappedBy="season",
     *      indexBy="round",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"date"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $races;

    /**
     * The prediction scoring system.
     *
     * @ORM\ManyToOne(targetEntity="ScoringSystem")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var ScoringSystem
     */
    protected $scoringSystem;

    /**
     * The season teams.
     *
     * @ORM\OneToMany(
     *      targetEntity="Team",
     *      mappedBy="season",
     *      cascade={"all"}
     * )
     *
     * @var ArrayCollection
     */
    protected $teams;

    /**
     * Constructor.
     *
     * @param int $year The season year as 4 digits
     */
    public function __construct($year)
    {
        $this->year = $year;
        $this->races = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    /**
     * Returns the season year.
     *
     * @return int The season year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Returns the season scoring system.
     *
     * @return ScoringSystem The season scoring system
     */
    public function getScoringSystem()
    {
        return $this->scoringSystem;
    }

    /**
     * Sets the season scoring system.
     *
     * @param ScoringSystem $system The prediction scoring system.
     *
     * @return $this
     */
    public function setScoringSystem(ScoringSystem $system)
    {
        $this->scoringSystem = $system;

        return $this;
    }

    /**
     * Returns a race by its round.
     *
     * @param int $round The race round
     *
     * @return Race|null The Race entity or null if not found
     */
    public function getRaceByRound($round)
    {
        return $this->races->get($round);
    }

    /**
     * Returns a race by its circuit.
     *
     * @param Circuit $circuit The race circuit
     *
     * @return Race|null The Race entity or null if not found
     */
    public function getRaceByCircuit(Circuit $circuit)
    {
        foreach ($this->races as $race) {
            if ($race->getCircuit() == $circuit) {
                return $race;
            }
        }

        return;
    }

    /**
     * Returns the last race with results.
     *
     * @return Race|null A Race entity or null if not found
     */
    public function getLastRaceWithResults()
    {
        $racesWithResults = $this->races->filter(function (Race $race) {
           return $race->hasResults();
        });

        return $racesWithResults->last();
    }

    public function getRaces() : Collection
    {
        return $this->races;
    }

    public function getRacesWithResults() : Collection
    {
        return $this->races->filter(function (Race $race) {
            return $race->hasResults();
        });
    }

    /**
     * @param Race $race
     *
     * @return $this
     */
    public function addRace(Race $race)
    {
        $race->setSeason($this);

        $this->races->set($race->getRound(), $race);

        return $this;
    }

    /**
     * Returns the season drivers.
     *
     * @return ArrayCollection A collection of Driver entities indexed by slug
     */
    public function getDrivers()
    {
        $drivers = new ArrayCollection();

        foreach ($this->teams as $team) {
            /* @var $team Team */
            $drivers->set($team->getDriver()->getSlug(), $team->getDriver());
        }

        return $drivers;
    }

    /**
     * Returns drivers by constructor.
     *
     * @param Constructor $constructor A constructor entity
     *
     * @return ArrayCollection A collection of Driver entities indexed by slug
     */
    public function getDriversByConstructor(Constructor $constructor)
    {
        $drivers = new ArrayCollection();

        foreach ($this->teams as $team) {
            /* @var $team Team */
            if ($team->getConstructor() == $constructor) {
                $drivers->set($team->getDriver()->getSlug(), $team->getDriver());
            }
        }

        return $drivers;
    }

    /**
     * Returns the season constructors.
     *
     * @return ArrayCollection A collection of Constructor entities indexed by slug
     */
    public function getConstructors()
    {
        $constructor = new ArrayCollection();

        foreach ($this->teams as $team) {
            /* @var $team Team */
            $constructor->set($team->getConstructor()->getSlug(), $team->getConstructor());
        }

        return $constructor;
    }

    /**
     * Returns the season teams.
     *
     * @return ArrayCollection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Adds a team.
     *
     * @param Team $team
     *
     * @return $this
     */
    public function addTeam(Team $team)
    {
        $team->setSeason($this);

        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    /**
     * Removes team.
     *
     * @param Team $team A Team entity
     *
     * @return $this
     */
    public function removeTeam(Team $team)
    {
        unset($this->teams[$this->teams->indexOf($team)]);

        return $this;
    }

    /**
     * Computes the season predictions points.
     *
     * @return $this
     */
    public function computePredictionsPoints()
    {
        foreach ($this->races as $race) {
            /* @var $race Race */
            $race
                ->computePredictionsPoints($this->scoringSystem)
                ->computeBonus($this->scoringSystem)
            ;
        }

        return $this;
    }

    /**
     * Returns whether the season is finished or not.
     *
     * @return bool true if the season is finished, false otherwise
     */
    public function isFinished()
    {
        return $this->races->last() && $this->races->last()->hasResults();
    }
}

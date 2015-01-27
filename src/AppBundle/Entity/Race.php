<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The race entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RaceRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"season_id", "round"}),
 *     @ORM\UniqueConstraint(columns={"season_id", "circuit_id"}),
 *     @ORM\UniqueConstraint(columns={"season_id", "date"}),
 * })
 * @UniqueEntity({"season", "round"})
 * @UniqueEntity({"season", "circuit"})
 * @UniqueEntity({"season", "date"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Race
{
    /**
     * The race identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The race round.
     *
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(value = 1)
     *
     * @var int
     */
    protected $round;

    /**
     * The race season.
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="races")
     * @ORM\JoinColumn(referencedColumnName="year", nullable=false)
     * @Assert\NotNull
     *
     * @var Season
     */
    protected $season;

    /**
     * The race name.
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $name;

    /**
     * The race circuit.
     *
     * @ORM\ManyToOne(targetEntity="Circuit", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Circuit
     */
    protected $circuit;

    /**
     * The race date.
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     *
     * @var \DateTime
     */
    protected $date;

    /**
     * The race active flag.
     *
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank
     *
     * @var bool
     */
    protected $active = true;

    /**
     * The race bonus.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @var int
     */
    protected $bonus = 0;

    /**
     * The race qualifying.
     *
     * @ORM\OneToMany(
     *      targetEntity="Qualifying",
     *      mappedBy="race",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $qualifying;

    /**
     * The race results.
     *
     * @ORM\OneToMany(
     *      targetEntity="Result",
     *      mappedBy="race",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $results;

    /**
     * The driver standings.
     *
     * @ORM\OneToMany(
     *      targetEntity="DriverStandings",
     *      mappedBy="race",
     *      cascade={"all"},
     *      indexBy="driver_id"
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $driverStandings;

    /**
     * The driver standings.
     *
     * @ORM\OneToMany(
     *      targetEntity="ConstructorStandings",
     *      mappedBy="race",
     *      cascade={"all"},
     *      indexBy="constructor_id"
     * )
     * @ORM\OrderBy({"position"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $constructorStandings;

    /**
     * The user standings.
     *
     * @ORM\OneToMany(
     *      targetEntity="UserStandings",
     *      mappedBy="race",
     *      indexBy="user_id",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"position"="ASC", "wins"="DESC"})
     *
     * @var ArrayCollection
     */
    protected $userStandings;

    /**
     * The user predictions.
     *
     * @ORM\OneToMany(
     *      targetEntity="Prediction",
     *      mappedBy="race",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"position"="ASC", "date"="DESC"})
     *
     * @var ArrayCollection
     */
    protected $predictions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->qualifying = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->driverStandings = new ArrayCollection();
        $this->constructorStandings = new ArrayCollection();
        $this->userStandings = new ArrayCollection();
        $this->predictions = new ArrayCollection();
    }

    /**
     * Returns the race identifier.
     *
     * @return int The race identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the season entity.
     *
     * @return Season The season entity
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Sets the season entity.
     *
     * @param Season $season The season entity
     *
     * @return $this
     */
    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Returns the race round.
     *
     * @return int The race round
     */
    public function getRound()
    {
        return $this->round;
    }

    /**
     * Sets the race round.
     *
     * @param int $round The race round
     *
     * @return $this
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Returns the race name.
     *
     * @return string The race name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the race name.
     *
     * @param string $name The race name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the race date.
     *
     * @return \DateTime The race date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the race date.
     *
     * @param \DateTime $date The race date
     *
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        if ($date != $this->date) {
            $this->date = $date;
        }

        return $this;
    }

    /**
     * Returns the race circuit.
     *
     * @return Circuit The race circuit
     */
    public function getCircuit()
    {
        return $this->circuit;
    }

    /**
     * Sets the race circuit.
     *
     * @param Circuit $circuit The race circuit
     *
     * @return $this
     */
    public function setCircuit(Circuit $circuit)
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return $this
     */
    public function active()
    {
        $this->active = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function inactive()
    {
        $this->active = false;

        return $this;
    }

    /**
     * Returns the race bonus.
     *
     * @return int The race bonus
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Sets the race bonus.
     *
     * @param int $bonus The race bonus
     *
     * @return $this
     */
    public function setBonus($bonus)
    {
        $this->bonus = max(0, $bonus);

        return $this;
    }

    /**
     * Returns the race qualifying.
     *
     * @return ArrayCollection the race qualifying
     */
    public function getQualifying()
    {
        return $this->qualifying;
    }

    /**
     * Adds qualifying.
     *
     * @param Qualifying $qualifying
     *
     * @return $this
     */
    public function addQualifying(Qualifying $qualifying)
    {
        $qualifying->setRace($this);

        $this->qualifying->add($qualifying);

        return $this;
    }

    /**
     * Removes a qualifying.
     *
     * @param Qualifying $qualifying The Qualifying entity
     *
     * @return $this
     */
    public function removeQualifying(Qualifying $qualifying)
    {
        unset($this->qualifying[$this->qualifying->indexOf($qualifying)]);

        return $this;
    }

    /**
     * @return bool
     */
    public function hasQualifying()
    {
        return !$this->qualifying->isEmpty();
    }

    /**
     * Returns the race results.
     *
     * @return ArrayCollection the race results
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Returns whether the race has results or not.
     *
     * @return bool true if the race has results, false otherwise
     */
    public function hasResults()
    {
        return !$this->results->isEmpty();
    }

    /**
     * Adds result.
     *
     * @param Result $result
     *
     * @return $this
     */
    public function addResult(Result $result)
    {
        $result->setRace($this);

        $this->results->add($result);

        return $this;
    }

    /**
     * Removes a result.
     *
     * @param Result $result The Result entity
     *
     * @return $this
     */
    public function removeResult(Result $result)
    {
        unset($this->results[$this->results->indexOf($result)]);

        return $this;
    }

    /**
     * Returns the constructor standings after this race.
     *
     * @return ArrayCollection A collection of ConstructorStanding entities
     */
    public function getConstructorStandings()
    {
        return $this->constructorStandings;
    }

    /**
     * Adds a constructor standings.
     *
     * @param ConstructorStandings $constructorStandings
     *
     * @return $this
     */
    public function addConstructorStandings(ConstructorStandings $constructorStandings)
    {
        $constructorStandings->setRace($this);

        $this->constructorStandings->add($constructorStandings);

        return $this;
    }

    /**
     * Removes a constructor standings.
     *
     * @param ConstructorStandings $constructorStandings The constructor standings to remove
     *
     * @return $this
     */
    public function removeConstructorStandings(ConstructorStandings $constructorStandings)
    {
        unset($this->constructorStandings[$constructorStandings->getConstructor()->getId()]);

        return $this;
    }

    /**
     * Returns the driver standings after this race.
     *
     * @return ArrayCollection A collection of DriverStanding entities
     */
    public function getDriverStandings()
    {
        return $this->driverStandings;
    }

    /**
     * Adds driver standings.
     *
     * @param DriverStandings $driverStandings
     *
     * @return $this
     */
    public function addDriverStandings(DriverStandings $driverStandings)
    {
        $driverStandings->setRace($this);

        $this->driverStandings->add($driverStandings);

        return $this;
    }

    /**
     * Returns a user standings.
     *
     * @param User $user A user entity
     *
     * @return UserStandings|null
     */
    public function getUserStandingsByUser(User $user)
    {
        return $this->userStandings->get($user->getId());
    }

    /**
     * Returns the user standings after this race.
     *
     * @return ArrayCollection A collection of UserStanding entities.
     */
    public function getUserStandings()
    {
        return $this->userStandings;
    }

    /**
     * Sets the user standings.
     *
     * @param ArrayCollection $userStandings
     *
     * @return $this
     */
    public function setUserStandings(ArrayCollection $userStandings)
    {
        $this->userStandings = new ArrayCollection();

        foreach ($userStandings as $userStanding) {
            $this->addUserStanding($userStanding);
        }

        return $this;
    }

    /**
     * Adds user standings.
     *
     * @param UserStandings $userStandings
     *
     * @return $this
     */
    public function addUserStanding(UserStandings $userStandings)
    {
        $userStandings->setRace($this);

        $this->userStandings->set($userStandings->getUser()->getId(), $userStandings);

        return $this;
    }

    /**
     * Returns the race predictions.
     *
     * @return ArrayCollection The race predictions
     */
    public function getPredictions()
    {
        return $this->predictions;
    }

    /**
     * Returns the user prediction.
     *
     * @param User $user A user entity
     *
     * @return Prediction|null
     */
    public function getPredictionByUser(User $user)
    {
        foreach ($this->predictions as $prediction) {
            /* @var $prediction Prediction */
            if ($prediction->getUser() == $user) {
                return $prediction;
            }
        }

        return;
    }

    /**
     * Returns whether the race has predictions or not.
     *
     * @return bool true if the race has predictions, false otherwise
     */
    public function hasPredictions()
    {
        return !$this->predictions->isEmpty();
    }

    /**
     * Adds a prediction.
     *
     * @param Prediction $prediction
     *
     * @return $this
     */
    public function addPrediction(Prediction $prediction)
    {
        $prediction->setRace($this);

        $this->predictions->add($prediction);

        return $this;
    }

    /**
     * @param ArrayCollection $predictions
     *
     * @return $this
     */
    public function setPredictions(ArrayCollection $predictions)
    {
        $this->predictions = $predictions;

        return $this;
    }

    /**
     * Computes the bonus race.
     *
     * @param ScoringSystem $system
     *
     * @return $this
     */
    public function computeBonus(ScoringSystem $system)
    {
        if ($this->predictions->isEmpty()) {
            $this->setBonus(0);
        } else {
            // extract predictions points
            $points = $this->predictions->map(function (Prediction $prediction) {
                return $prediction->getPoints();
            });

            // compute race bonus from the lowest prediction points
            $this->setBonus(min($points->toArray()) - $system->getBonus());
        }

        return $this;
    }

    /**
     * Computes the race predictions points.
     *
     * @param ScoringSystem $system
     *
     * @return $this
     */
    public function computePredictionsPoints(ScoringSystem $system)
    {
        // compute predictions points
        foreach ($this->predictions as $prediction) {
            /* @var $prediction Prediction */
            $prediction->computePoints($system);
        }

        // set prediction positions
        $this->predictions = $this->predictions->matching(
            Criteria::create()->orderBy(['points' => Criteria::DESC, 'date' => Criteria::ASC])
        );

        $position = 1;

        foreach ($this->predictions as $prediction) {
            /* @var $prediction Prediction */
            $prediction->setPosition($position++);
        }

        return $this;
    }
}

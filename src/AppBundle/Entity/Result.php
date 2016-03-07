<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The result entity.
 *
 * Cause of shared drives, a position can contains multiple drivers
 * and a driver can have multiple results cause of shared drives.
 *
 * @see http://en.wikipedia.org/wiki/1960_Argentine_Grand_Prix
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 * @ORM\Table
 * @UniqueEntity({"race", "team", "position"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Result
{
    /**
     * The result race.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Race
     */
    protected $race;

    /**
     * The team entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Team
     */
    protected $team;

    /**
     * The driver position.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="1")
     *
     * @var int
     */
    protected $position;

    /**
     * The driver grid position.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="1")
     *
     * @var int
     */
    protected $grid;

    /**
     * The result points.
     *
     * This is a float because in some Formula 1 rules,
     * if 75% of the race distance has not been completed
     * and the race cannot be resumed, half points are awarded.
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var float
     */
    protected $points = 0.0;

    /**
     * The result laps.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    protected $laps;

    /**
     * The result time.
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $time;

    /**
     * The result milliseconds.
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $milliseconds;

    /**
     * The fastest lap.
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $fastestLap;

    /**
     * The fastest lap rank.
     *
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var int
     */
    protected $fastestLapRank;

    /**
     * The fastest lap time.
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $fastestLapTime;

    /**
     * The fastest lap speed.
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    protected $fastestLapSpeed;

    /**
     * The finishing status.
     *
     * @ORM\ManyToOne(targetEntity="FinishingStatus")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var FinishingStatus
     */
    protected $finishingStatus;

    /**
     * Returns the race entity.
     *
     * @return Race The race entity
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * Sets the race entity.
     *
     * @param Race $race The race entity
     *
     * @return $this
     */
    public function setRace(Race $race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Returns the Team.
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Sets the Team.
     *
     * @param Team $team
     *
     * @return $this
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get grid.
     *
     * @return int
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Set grid.
     *
     * @param int $grid
     *
     * @return $this
     */
    public function setGrid($grid)
    {
        $this->grid = $grid;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get points.
     *
     * @return float
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set points.
     *
     * @param float $points
     *
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get laps.
     *
     * @return int
     */
    public function getLaps()
    {
        return $this->laps;
    }

    /**
     * Set laps.
     *
     * @param int $laps
     *
     * @return $this
     */
    public function setLaps($laps)
    {
        $this->laps = $laps;

        return $this;
    }

    /**
     * Get time.
     *
     * @return string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set time.
     *
     * @param string $time
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get milliseconds.
     *
     * @return int
     */
    public function getMilliseconds()
    {
        return $this->milliseconds;
    }

    /**
     * Set milliseconds.
     *
     * @param int $milliseconds
     *
     * @return $this
     */
    public function setMilliseconds($milliseconds)
    {
        $this->milliseconds = $milliseconds;

        return $this;
    }

    /**
     * Get fastestLap.
     *
     * @return int
     */
    public function getFastestLap()
    {
        return $this->fastestLap;
    }

    /**
     * Set fastestLap.
     *
     * @param int $fastestLap
     *
     * @return $this
     */
    public function setFastestLap($fastestLap)
    {
        $this->fastestLap = $fastestLap;

        return $this;
    }

    /**
     * Get fastestLapRank.
     *
     * @return int
     */
    public function getFastestLapRank()
    {
        return $this->fastestLapRank;
    }

    /**
     * Set fastestLapRank.
     *
     * @param int $fastestLapRank
     *
     * @return $this
     */
    public function setFastestLapRank($fastestLapRank)
    {
        $this->fastestLapRank = $fastestLapRank;

        return $this;
    }

    /**
     * Get fastestLapTime.
     *
     * @return string
     */
    public function getFastestLapTime()
    {
        return $this->fastestLapTime;
    }

    /**
     * Set fastestLapTime.
     *
     * @param string $fastestLapTime
     *
     * @return $this
     */
    public function setFastestLapTime($fastestLapTime)
    {
        $this->fastestLapTime = $fastestLapTime;

        return $this;
    }

    /**
     * Get fastestLapSpeed.
     *
     * @return string
     */
    public function getFastestLapSpeed()
    {
        return $this->fastestLapSpeed;
    }

    /**
     * Set fastestLapSpeed.
     *
     * @param string $fastestLapSpeed
     *
     * @return $this
     */
    public function setFastestLapSpeed($fastestLapSpeed)
    {
        if ($this->fastestLapSpeed != $fastestLapSpeed) {
            $this->fastestLapSpeed = $fastestLapSpeed;
        }

        return $this;
    }

    /**
     * Get status.
     *
     * @return FinishingStatus
     */
    public function getFinishingStatus()
    {
        return $this->finishingStatus;
    }

    /**
     * Set status.
     *
     * @param FinishingStatus $status
     *
     * @return $this
     */
    public function setFinishingStatus(FinishingStatus $status)
    {
        $this->finishingStatus = $status;

        return $this;
    }

    /**
     * Converts the object to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->position;
    }
}

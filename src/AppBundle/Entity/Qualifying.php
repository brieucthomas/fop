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
 * The qualifying entity.
 *
 * Cause of shared drives, a position can contains multiple drivers
 * and a driver can have multiple results cause of shared drives.
 *
 * @see http://en.wikipedia.org/wiki/1960_Argentine_Grand_Prix
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QualifyingRepository")
 * @ORM\Table
 * @UniqueEntity({"race", "team", "position"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Qualifying
{
    /**
     * The Race entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="qualifying")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Race
     */
    protected $race;

    /**
     * The Team entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Team
     */
    protected $team;

    /**
     * The position.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 1)
     *
     * @var int
     */
    protected $position;

    /**
     * The Q1 time.
     *
     * @ORM\Column(type="string", nullable=true, length=12)
     * @Assert\Length(min="0", max="12")
     *
     * @var string
     */
    protected $q1;

    /**
     * The Q2 time.
     *
     * @ORM\Column(type="string", nullable=true, length=12)
     * @Assert\Length(min="0", max="12")
     *
     * @var string
     */
    protected $q2;

    /**
     * The Q3 time.
     *
     * @ORM\Column(type="string", nullable=true, length=12)
     * @Assert\Length(min="0", max="12")
     *
     * @var string
     */
    protected $q3;

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
     * @param Race $race
     *
     * @return $this
     */
    public function setRace(Race $race)
    {
        $this->race = $race;

        return $this;
    }

    /**
     * Returns the Team entity.
     *
     * @return Team A Team entity
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Sets the Team entity.
     *
     * @param Team $team A Team entity
     *
     * @return $this
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Returns the grid position.
     *
     * @return int The grid position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the grid position.
     *
     * @param int $position The grid position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Returns the Q1 time.
     *
     * @return string The Q1 time
     */
    public function getQ1()
    {
        return $this->q1;
    }

    /**
     * Sets the Q1 time.
     *
     * @param string $q1 The Q1 time
     *
     * @return $this
     */
    public function setQ1($q1)
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * Returns the Q2 time.
     *
     * @return string The Q2 time
     */
    public function getQ2()
    {
        return $this->q2;
    }

    /**
     * Sets the Q2 time.
     *
     * @param string $q2 The Q2 time
     *
     * @return $this
     */
    public function setQ2($q2)
    {
        $this->q2 = $q2;

        return $this;
    }

    /**
     * Returns the Q3 time.
     *
     * @return string The Q3 time
     */
    public function getQ3()
    {
        return $this->q3;
    }

    /**
     * Sets the Q3 time.
     *
     * @param string $q3 The Q3 time
     *
     * @return $this
     */
    public function setQ3($q3)
    {
        $this->q3 = $q3;

        return $this;
    }
}

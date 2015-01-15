<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Base class for standings entities.
 *
 * @ORM\MappedSuperclass
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
abstract class AbstractStandings
{
    /**
     * The standings position.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 1)
     *
     * @var int
     */
    protected $position;

    /**
     * The number of scored points.
     *
     * This is a float because in some Formula 1 rules,
     * if 75% of the race distance has not been completed
     * and the race cannot be resumed, half points are awarded.
     *
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @var float
     */
    protected $points = 0.0;

    /**
     * The number of wins.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @var int
     */
    protected $wins = 0;

    /**
     * Returns the standings position.
     *
     * @return int The standings position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the standings position.
     *
     * @param int $position The standings position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Returns the number of scored points.
     *
     * @return float The number of scored points.
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the number scored points.
     *
     * @param float $points The number scored points
     *
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Adds points.
     *
     * @param float $points The number of points to add
     *
     * @return $this
     */
    public function addPoints($points)
    {
        $this->points += (float) $points;

        return $this;
    }

    /**
     * Returns the number of wins.
     *
     * @return int The number of wins
     */
    public function getWins()
    {
        return $this->wins;
    }

    /**
     * Sets the number of wins.
     *
     * @param int $wins the number of wins
     *
     * @return $this
     */
    public function setWins($wins)
    {
        $this->wins = $wins;

        return $this;
    }

    /**
     * Increases the number of wins.
     *
     * @return $this
     */
    public function increaseWins()
    {
        $this->wins++;

        return $this;
    }
}

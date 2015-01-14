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
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * The ScoringSystem entity.
 *
 * @ORM\Entity
 * @ORM\Table
 * @UniqueEntity({"system", "offset"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ScoringSystemOffset
{
    /**
     * The scoring system.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="ScoringSystem", inversedBy="offsets")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var ScoringSystem
     */
    protected $system;

    /**
     * The scoring offset.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(0)
     *
     * @var int
     */
    protected $offset;

    /**
     * The scoring points.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(0)
     *
     * @var int
     */
    protected $points;

    /**
     * Constructor.
     *
     * @param int $offset The offset value
     * @param int $points The points value
     */
    public function __construct($offset, $points)
    {
        $this
            ->setOffset($offset)
            ->setPoints($points)
        ;
    }

    /**
     * Returns the scoring system.
     *
     * @return ScoringSystem The scoring system
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * Sets the scoring system.
     *
     * @param ScoringSystem $scoringSystem The scoring system
     *
     * @return $this
     */
    public function setSystem(ScoringSystem $scoringSystem)
    {
        $this->system = $scoringSystem;

        return $this;
    }

    /**
     * Returns the scoring offset.
     *
     * @return int The scoring offset
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Sets the scoring offset.
     *
     * @param int $offset The scoring offset
     *
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Returns the scoring points.
     *
     * @return int The scoring points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the scoring points.
     *
     * @param int $points The scoring points
     *
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }
}

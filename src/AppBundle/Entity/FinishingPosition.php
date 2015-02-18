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
 * The position entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FinishingPositionRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"prediction_id", "team_id"}),
 *     @ORM\UniqueConstraint(columns={"prediction_id", "predicted_position"})
 * })
 * @UniqueEntity({"prediction", "team"})
 * @UniqueEntity({"prediction", "predictedPosition"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingPosition
{
    /**
     * The prediction identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The prediction entity.
     *
     * @ORM\ManyToOne(targetEntity="Prediction", inversedBy="finishingPositions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Prediction
     */
    protected $prediction;

    /**
     * The predicted position.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(1)
     *
     * @var int
     */
    protected $predictedPosition;

    /**
     * The team entity.
     *
     * @ORM\ManyToOne(targetEntity="Team")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Team
     */
    protected $team;

    /**
     * The finishing position.
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(1)
     *
     * @var int
     */
    protected $finishingPosition;

    /**
     * The points.
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     *
     * @var int
     */
    protected $points;

    /**
     * Return the identifier identifier.
     *
     * @return int The identifier identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the prediction entity.
     *
     * @return Prediction The prediction entity
     */
    public function getPrediction()
    {
        return $this->prediction;
    }

    /**
     * Sets the prediction entity.
     *
     * @param Prediction $prediction The prediction entity
     *
     * @return $this
     */
    public function setPrediction(Prediction $prediction)
    {
        $this->prediction = $prediction;

        return $this;
    }

    /**
     * Returns the predicted position.
     *
     * @return int The predicted position
     */
    public function getPredictedPosition()
    {
        return $this->predictedPosition;
    }

    /**
     * Sets the FinishingPosition Position.
     *
     * @param int $position The FinishingPosition Position
     *
     * @return $this
     */
    public function setPredictedPosition($position)
    {
        $this->predictedPosition = $position;

        return $this;
    }

    /**
     * Returns the Team entity.
     *
     * @return Team The Team entity
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Sets the Team entity.
     *
     * @param Team $team The Team entity
     *
     * @return $this
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Returns the finishing position.
     *
     * @return int The finishing position
     */
    public function getFinishingPosition()
    {
        return $this->finishingPosition;
    }

    /**
     * Sets the finishing position.
     *
     * @param int $finishingPosition The finishing position
     *
     * @return $this
     */
    public function setFinishingPosition($finishingPosition)
    {
        $this->finishingPosition = $finishingPosition;

        return $this;
    }

    /**
     * Returns the prediction points.
     *
     * @return int The prediction points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Sets the prediction points.
     *
     * @param int $points The prediction points
     *
     * @return $this
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Computes this prediction score.
     *
     * @param ScoringSystem $system
     *
     * @return $this
     */
    public function computePoints(ScoringSystem $system)
    {
        $points = 0;

        if ($this->finishingPosition > 0) {
            $points = $system->getPointsByPositions($this->predictedPosition, $this->finishingPosition);
        }

        $this->setPoints($points);

        return $this;
    }
}

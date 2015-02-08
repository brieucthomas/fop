<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The result prediction entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PredictionRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"race_id", "user_id"}),
 * })
 * @UniqueEntity({"race", "user"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Prediction
{
    const ENABLED = 1;

    /**
     * The prediction identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The race entity.
     *
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="predictions")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Race
     */
    protected $race;

    /**
     * The user entity.
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var User
     */
    protected $user;

    /**
     * The prediction position.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @var int
     */
    protected $position = 0;

    /**
     * The prediction points.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @var int
     */
    protected $points = 0;

    /**
     * The prediction status.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Choice(choices = {"1"})
     *
     * @var int
     */
    protected $status = self::ENABLED;

    /**
     * The finishing position predictions.
     *
     * @ORM\OneToMany(
     *      targetEntity="FinishingPosition",
     *      mappedBy="prediction",
     *      orphanRemoval=true,
     *      indexBy="predicted_position",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"predictedPosition"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $finishingPositions;

    /**
     * The identifier creation date.
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     *
     * @var \DateTime
     */
    protected $date;

    /**
     * Constructor.
     *
     * @param Race $race
     * @param User $user
     */
    public function __construct(Race $race, User $user)
    {
        $this->finishingPositions = new ArrayCollection();
        $this->date = new \DateTime();
        $this
            ->setRace($race)
            ->setUser($user)
        ;
    }

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
     * Returns the user entity.
     *
     * @return User The user entity
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Sets the user entity.
     *
     * @param User $user The user entity
     *
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWin()
    {
        return 1 === $this->position;
    }

    /**
     * Returns the prediction position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Sets the prediction position.
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
     * Returns the prediction status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the prediction status.
     *
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Returns the identifier creation date.
     *
     * @return \DateTime The identifier creation date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Returns the finishing position predictions.
     *
     * @return ArrayCollection A collection of PredictionPosition entities
     */
    public function getFinishingPositions()
    {
        return $this->finishingPositions;
    }

    /**
     * Adds a finishing position prediction.
     *
     * @param FinishingPosition $row
     *
     * @return $this
     */
    public function addFinishingPosition(FinishingPosition $row)
    {
        $row->setPrediction($this);

        $this->finishingPositions->set($row->getPredictedPosition(), $row);

        return $this;
    }

    /**
     * Computes the prediction points.
     *
     * @param ScoringSystem $system
     *
     * @return $this
     */
    public function computePoints(ScoringSystem $system)
    {
        $points = $this->finishingPositions->map(function (FinishingPosition $item) use ($system) {
            return $item->computePoints($system)->getPoints();
        });

        $this->setPoints(array_sum($points->toArray()));

        return $this;
    }

    /**
     * Returns whether the given user is the author of this prediction or not.
     *
     * @param User $user A User entity
     *
     * @return bool true if the given user is the author, false otherwise
     */
    public function isAuthor(User $user = null)
    {
        return $user && $user->getId() === $this->user->getId();
    }

    /**
     * __toString.
     *
     * @return string The owner username
     */
    public function __toString()
    {
        return (string) join(' - ', [
            $this->race->getSeason()->getYear(),
            $this->race->getName(),
            $this->user->getUsername()
        ]);
    }
}

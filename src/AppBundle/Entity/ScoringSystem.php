<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The prediction scoring system entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ScoringSystemRepository")
 * @ORM\Table
 * @UniqueEntity("name")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ScoringSystem
{
    /**
     * The scoring system identifier.
     *
     * @ORM\Id
     * @ORM\Column(type="string", length=24, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="24")
     * @Assert\Regex("/^[a-z\-]*$/")
     *
     * @var string
     */
    protected $id;

    /**
     * The scoring system length.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="1")
     *
     * @var int
     */
    protected $length;

    /**
     * A collection of offsets.
     *
     * @ORM\OneToMany(
     *      targetEntity="ScoringSystemOffset",
     *      mappedBy="system",
     *      indexBy="offset",
     *      cascade={"all"}
     * )
     * @ORM\OrderBy({"offset"="ASC"})
     *
     * @var ArrayCollection
     */
    protected $offsets = array();

    /**
     * The scoring system bonus.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\GreaterThanOrEqual(value="0")
     *
     * @var int
     */
    protected $bonus = 0;

    /**
     * The default flag.
     *
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    protected $isDefault = true;

    /**
     * Constructor.
     *
     * @param string $id The scoring system identifier
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->offsets = new ArrayCollection();
    }

    /**
     * Returns the scoring system identifier.
     *
     * @return int The scoring system identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the scoring system length.
     *
     * @return int The scoring system length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Sets the scoring system length.
     *
     * @param int $length The scoring system length.
     *
     * @return $this
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }

    /**
     * Returns a collection of offsets.
     *
     * @return ArrayCollection A collection of ScoringSystemOffset entities
     */
    public function getOffsets()
    {
        return $this->offsets;
    }

    /**
     * Returns the associated scoring.
     *
     * @param int $offset The offset value
     *
     * @return ScoringSystemOffset|null An offset entity or null if not found
     */
    public function getOffset($offset)
    {
        return $this->offsets->get($offset);
    }

    /**
     * Adds an offset.
     *
     * @param ScoringSystemOffset $offset An PredictionScoringSystemOffset entity
     *
     * @return $this
     */
    public function addOffset(ScoringSystemOffset $offset)
    {
        $offset->setSystem($this);

        $this->offsets->set($offset->getOffset(), $offset);

        return $this;
    }

    /**
     * Returns the scoring system bonus.
     *
     * @return int The scoring system bonus
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Sets the scoring system bonus.
     *
     * @param int $bonus The scoring system bonus
     *
     * @return $this
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Returns the default flag.
     *
     * @return boolean
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

    /**
     * Sets the default flag.
     *
     * @param boolean $default
     *
     * @return $this
     */
    public function setIsDefault($default)
    {
        $this->isDefault = $default ? true : false;

        return $this;
    }

    /**
     * Returns the scored points.
     *
     * @param int $predictedPosition The predicted position
     * @param int $finishingPosition The finishing position
     *
     * @return int The scored points
     */
    public function getPointsByPositions($predictedPosition, $finishingPosition)
    {
        if (($predictedPosition > $this->length) || ($finishingPosition > $this->length)) {
            return 0;
        }

        $offset = abs($finishingPosition - $predictedPosition);

        if ($entity = $this->offsets->get($offset)) {
            /* @var $entity ScoringSystemOffset */
            return $entity->getPoints();
        }

        return 0;
    }
}

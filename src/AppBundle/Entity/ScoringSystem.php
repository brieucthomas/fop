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
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The scoring system name.
     *
     * @ORM\Column(type="string", unique=true, length=16)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="16")
     *
     * @var string
     */
    protected $name;

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
     * @ORM\Column(type="array")
     *
     * @var array
     */
    protected $offsets = [];

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
     * Returns the scoring system identifier.
     *
     * @return int The scoring system identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the scoring system name.
     *
     * @return string The scoring system name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the scoring system name.
     *
     * @param string $name The scoring system name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return array
     */
    public function getOffsets()
    {
        return $this->offsets;
    }

    /**
     * Sets a collection of offsets.
     *
     * @param array $offsets
     *
     * @return $this
     */
    public function setOffsets(array $offsets)
    {
        $this->offsets = $offsets;

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

        if (isset($this->offsets[$offset])) {
            return $this->offsets[$offset];
        }

        return 0;
    }

    /**
     * __toString.
     *
     * @return string The scoring system name
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}

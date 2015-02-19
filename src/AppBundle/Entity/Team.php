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
 * The team entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TeamRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"season_id", "constructor_id", "driver_id"}),
 * })
 * @UniqueEntity({"season", "constructor", "driver"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Team
{
    /**
     * The entity identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The race season.
     *
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="teams")
     * @ORM\JoinColumn(referencedColumnName="year", nullable=false)
     * @Assert\NotNull
     *
     * @var Season
     */
    protected $season;

    /**
     * The constructor entity.
     *
     * @ORM\ManyToOne(targetEntity="Constructor", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Constructor
     */
    protected $constructor;

    /**
     * The driver entity.
     *
     * @ORM\ManyToOne(targetEntity="Driver", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Driver
     */
    protected $driver;

    /**
     * Returns the entity identifier.
     *
     * @return int The entity identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the Season.
     *
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Sets the Season.
     *
     * @param Season $season
     *
     * @return $this
     */
    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Returns the Constructor.
     *
     * @return Constructor
     */
    public function getConstructor()
    {
        return $this->constructor;
    }

    /**
     * Sets the Constructor.
     *
     * @param Constructor $constructor
     *
     * @return $this
     */
    public function setConstructor(Constructor $constructor)
    {
        $this->constructor = $constructor;

        return $this;
    }

    /**
     * Returns the Driver.
     *
     * @return Driver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Sets the Driver.
     *
     * @param Driver $driver
     *
     * @return $this
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(' - ', [
            $this->getSeason()->getYear(),
            $this->getDriver()->getName(),
            $this->constructor->getName(),
        ]);
    }
}

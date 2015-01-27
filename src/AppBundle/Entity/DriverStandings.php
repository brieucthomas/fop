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
 * The DriverStandings entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriverStandingsRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"race_id", "driver_id"}),
 * })
 * @UniqueEntity({"race", "driver"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class DriverStandings extends AbstractStandings
{
    /**
     * The race entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="driverStandings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Race
     */
    protected $race;

    /**
     * The driver entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Driver")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Driver
     */
    protected $driver;

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
     * Returns the driver entity.
     *
     * @return Driver The driver entity
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * Sets the driver entity.
     *
     * @param Driver $driver The driver entity
     *
     * @return $this
     */
    public function setDriver(Driver $driver)
    {
        $this->driver = $driver;

        return $this;
    }
}

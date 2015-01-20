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
 * The constructor standings entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConstructorStandingsRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"race_id", "constructor_id"})
 * })
 * @UniqueEntity({"race", "constructor"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ConstructorStandings extends AbstractStandings
{
    /**
     * The race entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="constructorStandings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Race
     */
    protected $race;

    /**
     * The constructor entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Constructor")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     *
     * @var Constructor
     */
    protected $constructor;

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
     * Returns the constructor entity.
     *
     * @return Constructor The constructor entity
     */
    public function getConstructor()
    {
        return $this->constructor;
    }

    /**
     * Returns the constructor entity.
     *
     * @param Constructor $constructor The constructor entity
     *
     * @return $this
     */
    public function setConstructor(Constructor $constructor)
    {
        $this->constructor = $constructor;

        return $this;
    }
}

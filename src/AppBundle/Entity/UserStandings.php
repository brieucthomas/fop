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
 * The user standings entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserStandingsRepository")
 * @ORM\Table(uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"race_id", "user_id"})
 * })
 * @UniqueEntity({"race", "user"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class UserStandings extends AbstractStandings
{
    /**
     * The race entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Race", inversedBy="userStandings")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     *
     * @var Race
     */
    protected $race;

    /**
     * The user entity.
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     *
     * @var User
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->setUser($user);
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
}

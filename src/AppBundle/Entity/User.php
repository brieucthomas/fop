<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * The user entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table
 * @UniqueEntity({"slug"})
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class User extends BaseUser
{
    /**
     * The user identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The user identifier.
     *
     * @Gedmo\Slug(fields={"username"})
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @var string
     */
    protected $slug;

    /**
     * The user account creation date.
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $created;

    /**
     * Returns the user slug.
     *
     * @return string The user slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Returns the account creation date.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}

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
 * The constructor entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConstructorRepository")
 * @ORM\Table
 * @UniqueEntity("id")
 * @UniqueEntity("name")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Constructor
{
    /**
     * The constructor identifier.
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
     * The constructor name.
     *
     * @ORM\Column(type="string", unique=true, length=128)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $name;

    /**
     * The constructor nationality code.
     *
     * @ORM\Column(type="string", length=2)
     * @Assert\Country
     *
     * @var string
     */
    protected $nationality;

    /**
     * Constructor.
     *
     * @param string $id The constructor identifier
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the constructor identifier.
     *
     * @return string The constructor identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the constructor name.
     *
     * @return string The constructor name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the constructor name.
     *
     * @param string $name The constructor name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the constructor nationality code.
     *
     * @return string The constructor nationality code
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Sets the constructor nationality code.
     *
     * @param string $nationality The constructor nationality code
     *
     * @return $this
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }
}

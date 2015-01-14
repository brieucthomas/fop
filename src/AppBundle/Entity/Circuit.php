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
 * The circuit entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CircuitRepository")
 * @ORM\Table
 * @UniqueEntity("id")
 * @UniqueEntity("name")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Circuit
{
    /**
     * The circuit identifier.
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
     * The circuit name.
     *
     * @ORM\Column(type="string", length=128, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $name;

    /**
     * The circuit location.
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $location;

    /**
     * The circuit country code.
     *
     * @ORM\Column(type="string", length=2)
     * @Assert\Country
     *
     * @var string
     */
    protected $country;

    /**
     * Constructor.
     *
     * @param string $id The circuit identifier
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Returns the circuit identifier.
     *
     * @return string The circuit identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the circuit name.
     *
     * @return string The circuit name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the circuit name.
     *
     * @param string $name The circuit name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the circuit location.
     *
     * @return string The circuit location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Sets the circuit location.
     *
     * @param string $location The circuit location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Returns the circuit country code.
     *
     * @return string The circuit country code
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Sets the circuit country code.
     *
     * @param string $country The circuit country code
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = strtoupper($country);

        return $this;
    }
}

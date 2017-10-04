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
 * The Driver entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DriverRepository")
 * @ORM\Table
 * @UniqueEntity("id")
 * @UniqueEntity("slug")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class Driver
{
    /**
     * The constructor identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The driver code as 3 letters.
     *
     * @ORM\Column(type="string", length=3, nullable=true)
     * @Assert\Regex("/^[A-Z]{3}$/")
     *
     * @var string
     */
    protected $code;

    /**
     * The driver permanent number.
     *
     * This permanent number must not be unique because he can be reallocated
     * if the driver associated with that number has driven in the last two
     * seasons.
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value = 1)
     *
     * @var int
     */
    protected $number;

    /**
     * The driver slug.
     *
     * @ORM\Column(type="string", length=24, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="24")
     * @Assert\Regex("/^[a-z\-]*$/")
     *
     * @var string
     */
    protected $slug;

    /**
     * The driver first name.
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $firstName;

    /**
     * The driver last name.
     *
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $lastName;

    /**
     * The driver date of birth.
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank
     * @Assert\Date
     *
     * @var \DateTime
     */
    protected $birthDate;

    /**
     * The driver nationality code.
     *
     * @ORM\Column(type="string", length=2)
     * @Assert\Country
     *
     * @var string
     */
    protected $nationality;

    /**
     * Returns the driver identifier.
     *
     * @return string The driver identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the driver code.
     *
     * @return string The driver code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the driver code.
     *
     * @param string $code The driver code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code ?: null;

        return $this;
    }

    /**
     * Returns the driver permanent number.
     *
     * @return int The driver permanent number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the driver permanent number.
     *
     * @param int $number The driver permanent number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Returns the driver slug.
     *
     * @return string The driver slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Sets the driver slug.
     *
     * @param string $slug The driver slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Returns the driver first name.
     *
     * @return string The driver first name
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the driver first name.
     *
     * @param string $firstName The driver first name
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Returns the driver last name.
     *
     * @return string The driver fist name
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the driver last name.
     *
     * @param string $lastName The driver last name
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Returns the driver date of birth.
     *
     * @return \DateTime The driver date of birth
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Sets the driver date of birth.
     *
     * @param \DateTime $birthDate The driver date of birth
     *
     * @return $this
     */
    public function setBirthDate(\DateTime $birthDate = null)
    {
        if ($birthDate !== $this->birthDate) {
            $this->birthDate = $birthDate;
        }

        return $this;
    }

    /**
     * Returns the driver nationality code.
     *
     * @return string The driver nationality code
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Sets the driver nationality code.
     *
     * @param string $nationality The driver nationality code
     *
     * @return $this
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Returns the driver name.
     *
     * @return string The driver name
     */
    public function getName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * Returns the driver short name.
     *
     * @return string The driver short name
     */
    public function getShortName()
    {
        return $this->firstName[0].'. '.$this->lastName;
    }
}

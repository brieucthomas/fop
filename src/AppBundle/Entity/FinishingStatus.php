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
 * The FinishingStatus entity.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FinishingStatusRepository")
 * @ORM\Table
 * @UniqueEntity("label")
 *
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class FinishingStatus
{
    /**
     * The finishing status identifier.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    protected $id;

    /**
     * The finishing status label.
     *
     * @ORM\Column(type="string", length=128, unique=true)
     * @Assert\NotBlank
     * @Assert\Length(max="128")
     *
     * @var string
     */
    protected $label;

    /**
     * Constructor.
     *
     * @param string $label The finishing status label
     */
    public function __construct($label)
    {
        $this->setLabel($label);
    }

    /**
     * Returns the status identifier.
     *
     * @return int The status identifier
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the status label.
     *
     * @return string The status label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the status label.
     *
     * @param string $status The status label
     *
     * @return $this
     */
    public function setLabel($status)
    {
        $this->label = $status;

        return $this;
    }
}

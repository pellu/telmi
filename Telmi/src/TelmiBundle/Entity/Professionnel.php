<?php

namespace TelmiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Professionnel
 *
 * @ORM\Table(name="professionnel")
 * @ORM\Entity(repositoryClass="TelmiBundle\Repository\ProfessionnelRepository")
 */
class Professionnel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var int
     *
     * @ORM\Column(name="matriculeId", type="integer")
     */
    private $matriculeId;

    /**
     * @var string
     *
     * @ORM\Column(name="workAddress", type="string", length=255)
     */
    private $workAddress;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Professionnel
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Professionnel
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set matriculeId
     *
     * @param integer $matriculeId
     *
     * @return Professionnel
     */
    public function setMatriculeId($matriculeId)
    {
        $this->matriculeId = $matriculeId;

        return $this;
    }

    /**
     * Get matriculeId
     *
     * @return int
     */
    public function getMatriculeId()
    {
        return $this->matriculeId;
    }

    /**
     * Set workAddress
     *
     * @param string $workAddress
     *
     * @return Professionnel
     */
    public function setWorkAddress($workAddress)
    {
        $this->workAddress = $workAddress;

        return $this;
    }

    /**
     * Get workAddress
     *
     * @return string
     */
    public function getWorkAddress()
    {
        return $this->workAddress;
    }
}


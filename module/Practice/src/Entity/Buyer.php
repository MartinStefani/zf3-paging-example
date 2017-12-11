<?php
declare(strict_types=1);

namespace Practice\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Practice\Repository\BuyerRepository")
 * @ORM\Table(name="Buyer")
 */
class Buyer
{
    /**
     * @ORM\Id
     * @ORM\Column(name="BuyerID", type="integer", name="BuyerID", length=11, unique=true, nullable=false)
     */
    protected $BuyerID;

    /**
     * @ORM\Column(name="FirstName", type="string", nullable=true)
     */
    protected $FirstName;

    /**
     * @ORM\Column(name="LastName", type="string", nullable=true)
     */
    protected $LastName;

    //region Relations
    /**
     * @ORM\OneToMany(targetEntity="\Practice\Entity\Vehicle", mappedBy="BuyerID")
     * @ORM\JoinColumn(name="BuyerID", referencedColumnName="id")
     */
    protected $vehicles;

    public function getVehicles()
    {
        return $this->vehicles;
    }

    public function addVehicle($vehicle)
    {
        $this->vehicles[] = $vehicle;
    }

    //endregion Relations

    //region Setters and Getters
    public function setBuyerID(int $buyerId)
    {
        $this->BuyerID = $buyerId;
    }

    public function getBuyerID(): int
    {
        return $this->BuyerID;
    }

    public function setFirstName(string $firstName)
    {
        $this->FirstName = $firstName;
    }

    public function getFirstName(): string
    {
        return $this->FirstName;
    }

    public function setLastName(string $lastName)
    {
        $this->LastName = $lastName;
    }

    public function getLastName(): string
    {
        return $this->LastName;
    }

    //endregion

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

}
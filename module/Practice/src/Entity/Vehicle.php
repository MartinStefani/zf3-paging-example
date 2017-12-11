<?php
declare(strict_types=1);

namespace Practice\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Vehicle")
 */
class Vehicle
{
    /**
     * @ORM\Id
     * @ORM\Column(name="VehicleID", type="integer", length=11, unique=true, nullable=false)
     */
    protected $VehicleID;

    /**
     * @ORM\Column(name="InhouseSellerID", type="integer", length=11, unique=false, nullable=false)
     */
    protected $InhouseSellerID;

    /**
     * @ORM\Column(name="BuyerID", type="integer", length=11, unique=false, nullable=false)
     */
    protected $BuyerID;

    /**
     * @ORM\Column(name="ModelID", type="integer", length=11, unique=false, nullable=false)
     */
    protected $ModelID;

    /**
     * @ORM\Column(name="SaleDate", type="date", nullable=false)
     */
    protected $SaleDate;

    /**
     * @ORM\Column(name="BuyDate", type="date", nullable=false)
     */
    protected $BuyDate;

    //region Relations
//    /**
//     * @ORM\ManyToOne(targetEntity="\Practice\Entity\Buyer", inversedBy="B")
//     * @ORM\JoinColumn(name="BuyerID", referencedColumnName="BuyerID")
//     */
//    protected $buyer;
//
//    /**
//     * Returns associated Buyer
//     * @return Buyer
//     */
//    public function getBuyer(): Buyer
//    {
//        return $this->buyer;
//    }
//
//    /**
//     * Sets associated Buyer
//     * @param \Practice\Entity\Buyer $buyer
//     */
//    public function setBuyer(Buyer $buyer)
//    {
//        $this->buyer = $buyer;
//        $buyer->addVehicle($this);
//    }
    //endregion Relations

    //region Setters and Getters
    public function setVehicleID(int $vehicleID)
    {
        $this->VehicleID = $vehicleID;
    }

    public function setInhouseSellerID(int $inhouseSellerID)
    {
        $this->InhouseSellerID = $inhouseSellerID;
    }

    public function setBuyerID(int $buyerID)
    {
        $this->BuyerID = $buyerID;
    }

    public function setModelID(int $modelID)
    {
        $this->ModelID = $modelID;
    }

    public function setSaleDate(string $saleDate)
    {
        $date = DateTime::createFromFormat('Y-m-d', $saleDate);
        $this->SaleDate = $date;
    }

    public function setBuyDate(string $buyDate)
    {
        $date = DateTime::createFromFormat('Y-m-d', $buyDate);
        $this->BuyDate = $date;
    }
    //endregion

}
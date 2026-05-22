<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TransportCostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: TransportCostRepository::class)]
class TransportCost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'transportCosts')]
    private ?Shipment $shipment = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $fuelCost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $driverCost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $maintenanceCost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalCost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShipment(): ?Shipment
    {
        return $this->shipment;
    }

    public function setShipment(?Shipment $shipment): static
    {
        $this->shipment = $shipment;

        return $this;
    }

    public function getFuelCost(): ?string
    {
        return $this->fuelCost;
    }

    public function setFuelCost(string $fuelCost): static
    {
        $this->fuelCost = $fuelCost;

        return $this;
    }

    public function getDriverCost(): ?string
    {
        return $this->driverCost;
    }

    public function setDriverCost(string $driverCost): static
    {
        $this->driverCost = $driverCost;

        return $this;
    }

    public function getMaintenanceCost(): ?string
    {
        return $this->maintenanceCost;
    }

    public function setMaintenanceCost(string $maintenanceCost): static
    {
        $this->maintenanceCost = $maintenanceCost;

        return $this;
    }

    public function getTotalCost(): ?string
    {
        return $this->totalCost;
    }

    public function setTotalCost(string $totalCost): static
    {
        $this->totalCost = $totalCost;

        return $this;
    }
}

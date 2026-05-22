<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\WarehouseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: WarehouseRepository::class)]
class Warehouse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\ManyToOne(inversedBy: 'warehouses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @var Collection<int, Shipment>
     */
    #[ORM\OneToMany(targetEntity: Shipment::class, mappedBy: 'departureWarehouse')]
    private Collection $departureShipments;

    /**
     * @var Collection<int, Shipment>
     */
    #[ORM\OneToMany(targetEntity: Shipment::class, mappedBy: 'arrivalWarehouse')]
    private Collection $arrivalShipments;

    public function __construct()
    {
        $this->departureShipments = new ArrayCollection();
        $this->arrivalShipments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Shipment>
     */
    public function getDepartureShipments(): Collection
    {
        return $this->departureShipments;
    }

    public function addDepartureShipment(Shipment $shipment): static
    {
        if (!$this->departureShipments->contains($shipment)) {
            $this->departureShipments->add($shipment);
            $shipment->setDepartureWarehouse($this);
        }

        return $this;
    }

    public function removeDepartureShipment(Shipment $shipment): static
    {
        if ($this->departureShipments->removeElement($shipment)) {
            if ($shipment->getDepartureWarehouse() === $this) {
                $shipment->setDepartureWarehouse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Shipment>
     */
    public function getArrivalShipments(): Collection
    {
        return $this->arrivalShipments;
    }

    public function addArrivalShipment(Shipment $shipment): static
    {
        if (!$this->arrivalShipments->contains($shipment)) {
            $this->arrivalShipments->add($shipment);
            $shipment->setArrivalWarehouse($this);
        }

        return $this;
    }

    public function removeArrivalShipment(Shipment $shipment): static
    {
        if ($this->arrivalShipments->removeElement($shipment)) {
            if ($shipment->getArrivalWarehouse() === $this) {
                $shipment->setArrivalWarehouse(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ShipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: ShipmentRepository::class)]
class Shipment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shipments')]
    private ?CustomerOrder $customerOrder = null;

    #[ORM\ManyToOne(inversedBy: 'shipments')]
    private ?Driver $driver = null;

    #[ORM\ManyToOne(inversedBy: 'shipments')]
    private ?Vehicle $vehicle = null;

    #[ORM\ManyToOne(inversedBy: 'departureShipments')]
    private ?Warehouse $departureWarehouse = null;

    #[ORM\ManyToOne(inversedBy: 'arrivalShipments')]
    private ?Warehouse $arrivalWarehouse = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $departureTime = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $arrivalTime = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    /**
     * @var Collection<int, TransportCost>
     */
    #[ORM\OneToMany(targetEntity: TransportCost::class, mappedBy: 'shipment')]
    private Collection $transportCosts;

    public function __construct()
    {
        $this->transportCosts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerOrder(): ?CustomerOrder
    {
        return $this->customerOrder;
    }

    public function setCustomerOrder(?CustomerOrder $customerOrder): static
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): static
    {
        $this->driver = $driver;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getDepartureWarehouse(): ?Warehouse
    {
        return $this->departureWarehouse;
    }

    public function setDepartureWarehouse(?Warehouse $departureWarehouse): static
    {
        $this->departureWarehouse = $departureWarehouse;

        return $this;
    }

    public function getArrivalWarehouse(): ?Warehouse
    {
        return $this->arrivalWarehouse;
    }

    public function setArrivalWarehouse(?Warehouse $arrivalWarehouse): static
    {
        $this->arrivalWarehouse = $arrivalWarehouse;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeImmutable
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeImmutable $departureTime): static
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeImmutable
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeImmutable $arrivalTime): static
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, TransportCost>
     */
    public function getTransportCosts(): Collection
    {
        return $this->transportCosts;
    }

    public function addTransportCost(TransportCost $transportCost): static
    {
        if (!$this->transportCosts->contains($transportCost)) {
            $this->transportCosts->add($transportCost);
            $transportCost->setShipment($this);
        }

        return $this;
    }

    public function removeTransportCost(TransportCost $transportCost): static
    {
        if ($this->transportCosts->removeElement($transportCost)) {
            // set the owning side to null (unless already changed)
            if ($transportCost->getShipment() === $this) {
                $transportCost->setShipment(null);
            }
        }

        return $this;
    }
}

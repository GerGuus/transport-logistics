<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\CustomerOrder;
use App\Entity\Driver;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\Shipment;
use App\Entity\TransportCost;
use App\Entity\Vehicle;
use App\Entity\Warehouse;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $company1 = (new Company())
            ->setName('Logistics Client LLC')
            ->setType('client')
            ->setContactPerson('John Carter')
            ->setPhone('+1-202-555-0101')
            ->setEmail('client1@example.com')
            ->setAddress('New York, 1st Avenue, 10');

        $company2 = (new Company())
            ->setName('Supply Partner Inc')
            ->setType('supplier')
            ->setContactPerson('Emma Stone')
            ->setPhone('+1-202-555-0102')
            ->setEmail('supplier@example.com')
            ->setAddress('Chicago, West Street, 25');

        $company3 = (new Company())
            ->setName('Fast Carrier Ltd')
            ->setType('carrier')
            ->setContactPerson('Michael Brown')
            ->setPhone('+1-202-555-0103')
            ->setEmail('carrier@example.com')
            ->setAddress('Los Angeles, Sunset Blvd, 50');

        $manager->persist($company1);
        $manager->persist($company2);
        $manager->persist($company3);

        $warehouse1 = (new Warehouse())
            ->setName('Main Warehouse')
            ->setAddress('New York, Industrial Zone, 1')
            ->setCompany($company1);

        $warehouse2 = (new Warehouse())
            ->setName('Reserve Warehouse')
            ->setAddress('Chicago, Storage Street, 12')
            ->setCompany($company2);

        $warehouse3 = (new Warehouse())
            ->setName('Transit Warehouse')
            ->setAddress('Los Angeles, Logistics Park, 7')
            ->setCompany($company3);

        $manager->persist($warehouse1);
        $manager->persist($warehouse2);
        $manager->persist($warehouse3);

        $product1 = (new Product())
            ->setName('Cement')
            ->setWeight('25.00')
            ->setVolume('0.03')
            ->setDescription('Cement bag 25kg');

        $product2 = (new Product())
            ->setName('Bricks')
            ->setWeight('3.50')
            ->setVolume('0.002')
            ->setDescription('Construction brick');

        $product3 = (new Product())
            ->setName('Paint')
            ->setWeight('10.00')
            ->setVolume('0.01')
            ->setDescription('Paint bucket 10L');

        $manager->persist($product1);
        $manager->persist($product2);
        $manager->persist($product3);

        $vehicle1 = (new Vehicle())
            ->setPlateNumber('AB1234CD')
            ->setType('truck')
            ->setCapacityWeight('10000.00')
            ->setCapacityVolume('60.00')
            ->setStatus('available');

        $vehicle2 = (new Vehicle())
            ->setPlateNumber('BC5678DE')
            ->setType('van')
            ->setCapacityWeight('3500.00')
            ->setCapacityVolume('18.00')
            ->setStatus('in_use');

        $manager->persist($vehicle1);
        $manager->persist($vehicle2);

        $driver1 = (new Driver())
            ->setFirstName('Alex')
            ->setLastName('Johnson')
            ->setPhone('+1-202-555-0201')
            ->setLicenseNumber('DL-10001')
            ->setStatus('available');

        $driver2 = (new Driver())
            ->setFirstName('Robert')
            ->setLastName('Williams')
            ->setPhone('+1-202-555-0202')
            ->setLicenseNumber('DL-10002')
            ->setStatus('in_trip');

        $manager->persist($driver1);
        $manager->persist($driver2);

        $order1 = (new CustomerOrder())
            ->setCompany($company1)
            ->setOrderDate(new \DateTimeImmutable('2026-05-20 10:00:00'))
            ->setStatus('new')
            ->setTotalWeight('250.00')
            ->setTotalVolume('0.53');

        $order2 = (new CustomerOrder())
            ->setCompany($company1)
            ->setOrderDate(new \DateTimeImmutable('2026-05-21 11:30:00'))
            ->setStatus('in_progress')
            ->setTotalWeight('520.00')
            ->setTotalVolume('1.20');

        $manager->persist($order1);
        $manager->persist($order2);

        $orderItem1 = (new OrderItem())
            ->setCustomerOrder($order1)
            ->setProduct($product1)
            ->setQuantity(10)
            ->setWeight('250.00')
            ->setVolume('0.30');

        $orderItem2 = (new OrderItem())
            ->setCustomerOrder($order1)
            ->setProduct($product3)
            ->setQuantity(3)
            ->setWeight('30.00')
            ->setVolume('0.03');

        $orderItem3 = (new OrderItem())
            ->setCustomerOrder($order2)
            ->setProduct($product2)
            ->setQuantity(120)
            ->setWeight('420.00')
            ->setVolume('0.90');

        $manager->persist($orderItem1);
        $manager->persist($orderItem2);
        $manager->persist($orderItem3);

        $shipment1 = (new Shipment())
            ->setCustomerOrder($order1)
            ->setDriver($driver1)
            ->setVehicle($vehicle1)
            ->setDepartureWarehouse($warehouse1)
            ->setArrivalWarehouse($warehouse2)
            ->setDepartureTime(new \DateTimeImmutable('2026-05-22 08:00:00'))
            ->setArrivalTime(new \DateTimeImmutable('2026-05-22 16:00:00'))
            ->setStatus('planned');

        $shipment2 = (new Shipment())
            ->setCustomerOrder($order2)
            ->setDriver($driver2)
            ->setVehicle($vehicle2)
            ->setDepartureWarehouse($warehouse2)
            ->setArrivalWarehouse($warehouse3)
            ->setDepartureTime(new \DateTimeImmutable('2026-05-23 09:00:00'))
            ->setArrivalTime(new \DateTimeImmutable('2026-05-23 18:30:00'))
            ->setStatus('in_transit');

        $manager->persist($shipment1);
        $manager->persist($shipment2);

        $transportCost1 = (new TransportCost())
            ->setShipment($shipment1)
            ->setFuelCost('120.00')
            ->setDriverCost('80.00')
            ->setMaintenanceCost('30.00')
            ->setTotalCost('230.00');

        $transportCost2 = (new TransportCost())
            ->setShipment($shipment2)
            ->setFuelCost('150.00')
            ->setDriverCost('90.00')
            ->setMaintenanceCost('40.00')
            ->setTotalCost('280.00');

        $manager->persist($transportCost1);
        $manager->persist($transportCost2);

        $manager->flush();
    }
}

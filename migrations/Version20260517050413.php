<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260517050413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, contact_person VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE customer_order (id INT AUTO_INCREMENT NOT NULL, order_date DATETIME NOT NULL, status VARCHAR(50) NOT NULL, total_weight NUMERIC(10, 2) NOT NULL, total_volume NUMERIC(10, 2) NOT NULL, company_id INT NOT NULL, INDEX IDX_3B1CE6A3979B1AD6 (company_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE driver (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(50) NOT NULL, license_number VARCHAR(100) NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, weight NUMERIC(10, 2) NOT NULL, volume NUMERIC(10, 2) NOT NULL, customer_order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_52EA1F09A15A2E17 (customer_order_id), INDEX IDX_52EA1F094584665A (product_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, weight NUMERIC(10, 2) NOT NULL, volume NUMERIC(10, 2) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, departure_time DATETIME NOT NULL, arrival_time DATETIME NOT NULL, status VARCHAR(50) NOT NULL, customer_order_id INT DEFAULT NULL, driver_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, departure_warehouse_id INT DEFAULT NULL, arrival_warehouse_id INT DEFAULT NULL, INDEX IDX_2CB20DCA15A2E17 (customer_order_id), INDEX IDX_2CB20DCC3423909 (driver_id), INDEX IDX_2CB20DC545317D1 (vehicle_id), INDEX IDX_2CB20DCF6CB0740 (departure_warehouse_id), INDEX IDX_2CB20DC4396490E (arrival_warehouse_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE transport_cost (id INT AUTO_INCREMENT NOT NULL, fuel_cost NUMERIC(10, 2) NOT NULL, driver_cost NUMERIC(10, 2) NOT NULL, maintenance_cost NUMERIC(10, 2) NOT NULL, total_cost NUMERIC(10, 2) NOT NULL, shipment_id INT DEFAULT NULL, INDEX IDX_C5F6C3797BE036FC (shipment_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, plate_number VARCHAR(50) NOT NULL, type VARCHAR(50) NOT NULL, capacity_weight NUMERIC(10, 2) NOT NULL, capacity_volume NUMERIC(10, 2) NOT NULL, status VARCHAR(50) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE warehouse (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT NOT NULL, company_id INT NOT NULL, INDEX IDX_ECB38BFC979B1AD6 (company_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE customer_order ADD CONSTRAINT FK_3B1CE6A3979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DCA15A2E17 FOREIGN KEY (customer_order_id) REFERENCES customer_order (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DCC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DC545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DCF6CB0740 FOREIGN KEY (departure_warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DC4396490E FOREIGN KEY (arrival_warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE transport_cost ADD CONSTRAINT FK_C5F6C3797BE036FC FOREIGN KEY (shipment_id) REFERENCES shipment (id)');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFC979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer_order DROP FOREIGN KEY FK_3B1CE6A3979B1AD6');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09A15A2E17');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DCA15A2E17');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DCC3423909');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC545317D1');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DCF6CB0740');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC4396490E');
        $this->addSql('ALTER TABLE transport_cost DROP FOREIGN KEY FK_C5F6C3797BE036FC');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFC979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE customer_order');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE shipment');
        $this->addSql('DROP TABLE transport_cost');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE warehouse');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

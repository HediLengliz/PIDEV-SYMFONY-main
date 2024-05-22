<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304021246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sinister CHANGE date_sinister date_sinister DATETIME NOT NULL, CHANGE status_sinister status_sinister VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sinister_vehicle CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sinistre CHANGE amount_sinister amount_sinister DOUBLE PRECISION DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE beneficiary_name beneficiary_name VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE claims claims JSON DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT \'NULL\' COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sinister CHANGE date_sinister date_sinister DATE DEFAULT \'NULL\', CHANGE status_sinister status_sinister VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sinister_vehicle CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sinistre CHANGE amount_sinister amount_sinister DOUBLE PRECISION DEFAULT \'NULL\', CHANGE description description VARCHAR(255) DEFAULT \'NULL\', CHANGE beneficiary_name beneficiary_name VARCHAR(20) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE claims claims LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\'');
    }
}

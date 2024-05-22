<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303120852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medical_sheet (id INT AUTO_INCREMENT NOT NULL, sinister_life_id INT NOT NULL, user_cin_id INT NOT NULL, medical_diagnosis LONGTEXT NOT NULL, treatment_plan LONGTEXT DEFAULT NULL, medical_reports LONGTEXT DEFAULT NULL, duration_of_incapacity INT DEFAULT NULL, procedure_performed LONGTEXT DEFAULT NULL, sick_leave_duration INT DEFAULT NULL, hospitalization_period INT DEFAULT NULL, rehabilitation_period INT DEFAULT NULL, medical_information LONGTEXT DEFAULT NULL, INDEX IDX_B2DACAB278AC42A8 (sinister_life_id), INDEX IDX_B2DACAB28C2B4E44 (user_cin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prescription (id INT AUTO_INCREMENT NOT NULL, user_cin_id INT NOT NULL, date_prescription DATE NOT NULL, medications LONGTEXT NOT NULL, status_prescription VARCHAR(20) NOT NULL, additional_notes LONGTEXT DEFAULT NULL, validity_duration INT DEFAULT NULL, INDEX IDX_1FBFB8D98C2B4E44 (user_cin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sinistre (id INT AUTO_INCREMENT NOT NULL, sinister_user_id INT NOT NULL, date_sinister DATE NOT NULL, location VARCHAR(255) NOT NULL, amount_sinister DOUBLE PRECISION DEFAULT NULL, status_sinister VARCHAR(20) NOT NULL, sinister_type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, beneficiary_name VARCHAR(20) DEFAULT NULL, INDEX IDX_F5AC7A67A2C9AFBE (sinister_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE medical_sheet ADD CONSTRAINT FK_B2DACAB278AC42A8 FOREIGN KEY (sinister_life_id) REFERENCES sinistre (id)');
        $this->addSql('ALTER TABLE medical_sheet ADD CONSTRAINT FK_B2DACAB28C2B4E44 FOREIGN KEY (user_cin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prescription ADD CONSTRAINT FK_1FBFB8D98C2B4E44 FOREIGN KEY (user_cin_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sinistre ADD CONSTRAINT FK_F5AC7A67A2C9AFBE FOREIGN KEY (sinister_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sinister CHANGE date_sinister date_sinister DATE DEFAULT NULL, CHANGE status_sinister status_sinister VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sinister_vehicle CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE claims claims JSON DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medical_sheet DROP FOREIGN KEY FK_B2DACAB278AC42A8');
        $this->addSql('ALTER TABLE medical_sheet DROP FOREIGN KEY FK_B2DACAB28C2B4E44');
        $this->addSql('ALTER TABLE prescription DROP FOREIGN KEY FK_1FBFB8D98C2B4E44');
        $this->addSql('ALTER TABLE sinistre DROP FOREIGN KEY FK_F5AC7A67A2C9AFBE');
        $this->addSql('DROP TABLE medical_sheet');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('DROP TABLE sinistre');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT \'NULL\' COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sinister CHANGE date_sinister date_sinister DATE DEFAULT \'NULL\', CHANGE status_sinister status_sinister VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE sinister_vehicle CHANGE image_name image_name VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE claims claims LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\'');
    }
}

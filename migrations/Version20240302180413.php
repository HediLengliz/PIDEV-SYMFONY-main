<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302180413 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, sinister_rapport_id INT DEFAULT NULL, decision VARCHAR(255) NOT NULL, justification VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BE34A09CE2DB65F3 (sinister_rapport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remorqueur (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, lattitude DOUBLE PRECISION NOT NULL, longuitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sinister (id INT AUTO_INCREMENT NOT NULL, sinister_user_id INT DEFAULT NULL, date_sinister DATE DEFAULT NULL, location VARCHAR(255) NOT NULL, status_sinister VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_73FC7B36A2C9AFBE (sinister_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sinister_property (id INT NOT NULL, type_degat VARCHAR(255) NOT NULL, description_degat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sinister_vehicle (id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, nom_conducteur_a VARCHAR(255) NOT NULL, nom_conducteur_b VARCHAR(255) NOT NULL, prenom_conducteur_b VARCHAR(255) NOT NULL, prenom_conducteur_a VARCHAR(255) NOT NULL, adresse_conducteur_a VARCHAR(255) NOT NULL, adresse_conducteur_b VARCHAR(255) NOT NULL, num_permis_a VARCHAR(255) NOT NULL, num_permis_b VARCHAR(255) NOT NULL, delivre_a DATE NOT NULL, delivre_b DATE NOT NULL, num_contrat_a VARCHAR(255) NOT NULL, num_contrat_b VARCHAR(255) NOT NULL, marque_vehicule_a VARCHAR(255) NOT NULL, marque_vehicule_b VARCHAR(255) NOT NULL, immatriculation_a VARCHAR(255) NOT NULL, immatriculation_b VARCHAR(255) NOT NULL, bvehicule_assure_par VARCHAR(255) NOT NULL, agence VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CE2DB65F3 FOREIGN KEY (sinister_rapport_id) REFERENCES sinister (id)');
        $this->addSql('ALTER TABLE sinister ADD CONSTRAINT FK_73FC7B36A2C9AFBE FOREIGN KEY (sinister_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sinister_property ADD CONSTRAINT FK_274B42E2BF396750 FOREIGN KEY (id) REFERENCES sinister (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sinister_vehicle ADD CONSTRAINT FK_1E2798ADBF396750 FOREIGN KEY (id) REFERENCES sinister (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE claims claims JSON DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CE2DB65F3');
        $this->addSql('ALTER TABLE sinister DROP FOREIGN KEY FK_73FC7B36A2C9AFBE');
        $this->addSql('ALTER TABLE sinister_property DROP FOREIGN KEY FK_274B42E2BF396750');
        $this->addSql('ALTER TABLE sinister_vehicle DROP FOREIGN KEY FK_1E2798ADBF396750');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE remorqueur');
        $this->addSql('DROP TABLE sinister');
        $this->addSql('DROP TABLE sinister_property');
        $this->addSql('DROP TABLE sinister_vehicle');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT \'NULL\' COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE claims claims LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\'');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303180711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, authorname VARCHAR(255) NOT NULL, datepub DATE NOT NULL, image LONGTEXT NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, article_c_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, rate LONGTEXT NOT NULL, INDEX IDX_9474526C7294869C (article_id), INDEX IDX_9474526C21951CD2 (article_c_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C21951CD2 FOREIGN KEY (article_c_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE quote CHANGE services services LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE sinister CHANGE date_sinister date_sinister DATE DEFAULT NULL, CHANGE status_sinister status_sinister VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sinister_vehicle CHANGE image_name image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sinistre CHANGE amount_sinister amount_sinister DOUBLE PRECISION DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE beneficiary_name beneficiary_name VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE claims claims JSON DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C21951CD2');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE comment');
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

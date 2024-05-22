<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302152525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, priority INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(20) NOT NULL, amount DOUBLE PRECISION NOT NULL, services LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_6B71CBF4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD21E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_auto (id INT NOT NULL, marque VARCHAR(255) DEFAULT NULL, modele VARCHAR(255) DEFAULT NULL, year VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_life (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_property (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD21E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE service_auto ADD CONSTRAINT FK_A8F99116BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_life ADD CONSTRAINT FK_D78E8A12BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_property ADD CONSTRAINT FK_728447E3BF396750 FOREIGN KEY (id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE claims claims JSON DEFAULT NULL, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4A76ED395');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD21E27F6BF');
        $this->addSql('ALTER TABLE service_auto DROP FOREIGN KEY FK_A8F99116BF396750');
        $this->addSql('ALTER TABLE service_life DROP FOREIGN KEY FK_D78E8A12BF396750');
        $this->addSql('ALTER TABLE service_property DROP FOREIGN KEY FK_728447E3BF396750');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_auto');
        $this->addSql('DROP TABLE service_life');
        $this->addSql('DROP TABLE service_property');
        $this->addSql('ALTER TABLE insurance_request CHANGE status status VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE life_request CHANGE chron_disease_description chron_disease_description VARCHAR(100) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE claims claims LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE image_file_name image_file_name VARCHAR(255) DEFAULT \'NULL\'');
    }
}

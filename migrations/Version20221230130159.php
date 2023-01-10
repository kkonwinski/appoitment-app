<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230130159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094F989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_additional_info (id INT AUTO_INCREMENT NOT NULL, company_address_id INT NOT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AAEC8DE4483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_address (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, post_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, building_number VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_2D1C7556979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_address_service (company_address_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F5895737483946E3 (company_address_id), INDEX IDX_F5895737ED5CA9E6 (service_id), PRIMARY KEY(company_address_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_schedule (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, day_from DATE NOT NULL, day_to DATE DEFAULT NULL, time_from TIME NOT NULL, time_to TIME DEFAULT NULL, repeat_infinity TINYINT(1) NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_CA07403CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', is_verified TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649989D9B62 (slug), INDEX IDX_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_additional_info ADD CONSTRAINT FK_AAEC8DE4483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
        $this->addSql('ALTER TABLE company_address ADD CONSTRAINT FK_2D1C7556979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE company_address_service ADD CONSTRAINT FK_F5895737483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_address_service ADD CONSTRAINT FK_F5895737ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_schedule ADD CONSTRAINT FK_CA07403CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_additional_info DROP FOREIGN KEY FK_AAEC8DE4483946E3');
        $this->addSql('ALTER TABLE company_address DROP FOREIGN KEY FK_2D1C7556979B1AD6');
        $this->addSql('ALTER TABLE company_address_service DROP FOREIGN KEY FK_F5895737483946E3');
        $this->addSql('ALTER TABLE company_address_service DROP FOREIGN KEY FK_F5895737ED5CA9E6');
        $this->addSql('ALTER TABLE employee_schedule DROP FOREIGN KEY FK_CA07403CA76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_additional_info');
        $this->addSql('DROP TABLE company_address');
        $this->addSql('DROP TABLE company_address_service');
        $this->addSql('DROP TABLE employee_schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
    }
}

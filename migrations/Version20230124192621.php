<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124192621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_address_addiotional_info (id INT AUTO_INCREMENT NOT NULL, company_address_id INT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_481EF63A483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_dictionary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province_dictionary (id INT AUTO_INCREMENT NOT NULL, company_address_id INT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3044A8AB483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_address_addiotional_info ADD CONSTRAINT FK_481EF63A483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
        $this->addSql('ALTER TABLE province_dictionary ADD CONSTRAINT FK_3044A8AB483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
        $this->addSql('ALTER TABLE employee_schedule DROP FOREIGN KEY FK_CA07403CA76ED395');
        $this->addSql('ALTER TABLE service_dictonary_service DROP FOREIGN KEY FK_C05E095C2EE47821');
        $this->addSql('ALTER TABLE service_dictonary_service DROP FOREIGN KEY FK_C05E095CED5CA9E6');
        $this->addSql('ALTER TABLE company_additional_info DROP FOREIGN KEY FK_AAEC8DE4483946E3');
        $this->addSql('ALTER TABLE service_dictionary_service DROP FOREIGN KEY FK_F62BB94D7FE1E1BE');
        $this->addSql('ALTER TABLE service_dictionary_service DROP FOREIGN KEY FK_F62BB94DED5CA9E6');
        $this->addSql('ALTER TABLE company_open_hours DROP FOREIGN KEY FK_7C29741D483946E3');
        $this->addSql('ALTER TABLE company_service DROP FOREIGN KEY FK_C1CF8005979B1AD6');
        $this->addSql('ALTER TABLE company_service DROP FOREIGN KEY FK_C1CF8005ED5CA9E6');
        $this->addSql('DROP TABLE employee_schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_dictonary_service');
        $this->addSql('DROP TABLE service_dictionary');
        $this->addSql('DROP TABLE company_additional_info');
        $this->addSql('DROP TABLE service_dictionary_service');
        $this->addSql('DROP TABLE company_open_hours');
        $this->addSql('DROP TABLE company_service');
        $this->addSql('DROP TABLE service_dictonary');
        $this->addSql('ALTER TABLE company ADD province_id INT NOT NULL, ADD country_dictionary_id INT NOT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD website VARCHAR(255) DEFAULT NULL, ADD zip_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FE946114A FOREIGN KEY (province_id) REFERENCES province_dictionary (id)');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094F5CEB89F8 FOREIGN KEY (country_dictionary_id) REFERENCES country_dictionary (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FE946114A ON company (province_id)');
        $this->addSql('CREATE INDEX IDX_4FBF094F5CEB89F8 ON company (country_dictionary_id)');
        $this->addSql('ALTER TABLE company_address ADD country_dictionary_id INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD zip_code VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(128) NOT NULL, DROP post_code, DROP country, DROP street, DROP building_number, CHANGE city city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE company_address ADD CONSTRAINT FK_2D1C75565CEB89F8 FOREIGN KEY (country_dictionary_id) REFERENCES country_dictionary (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D1C7556989D9B62 ON company_address (slug)');
        $this->addSql('CREATE INDEX IDX_2D1C75565CEB89F8 ON company_address (country_dictionary_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6');
        $this->addSql('DROP INDEX UNIQ_8D93D649989D9B62 ON user');
        $this->addSql('DROP INDEX IDX_8D93D649979B1AD6 ON user');
        $this->addSql('ALTER TABLE user DROP company_id, DROP is_verified, DROP firstname, DROP lastname, DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094F5CEB89F8');
        $this->addSql('ALTER TABLE company_address DROP FOREIGN KEY FK_2D1C75565CEB89F8');
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FE946114A');
        $this->addSql('CREATE TABLE employee_schedule (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, day_from DATE NOT NULL, day_to DATE DEFAULT NULL, time_from TIME NOT NULL, time_to TIME DEFAULT NULL, repeat_infinity TINYINT(1) NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_CA07403CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, duration INT NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, company_address_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_dictonary_service (service_dictonary_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_C05E095C2EE47821 (service_dictonary_id), INDEX IDX_C05E095CED5CA9E6 (service_id), PRIMARY KEY(service_dictonary_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_dictionary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE company_additional_info (id INT AUTO_INCREMENT NOT NULL, company_address_id INT NOT NULL, phone VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, facebook VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, instagram VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, website VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_AAEC8DE4483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_dictionary_service (service_dictionary_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F62BB94D7FE1E1BE (service_dictionary_id), INDEX IDX_F62BB94DED5CA9E6 (service_id), PRIMARY KEY(service_dictionary_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE company_open_hours (id INT AUTO_INCREMENT NOT NULL, company_address_id INT NOT NULL, day_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, open_from TIME NOT NULL, open_to TIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7C29741D483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE company_service (company_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_C1CF8005979B1AD6 (company_id), INDEX IDX_C1CF8005ED5CA9E6 (service_id), PRIMARY KEY(company_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service_dictonary (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE employee_schedule ADD CONSTRAINT FK_CA07403CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_dictonary_service ADD CONSTRAINT FK_C05E095C2EE47821 FOREIGN KEY (service_dictonary_id) REFERENCES service_dictonary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_dictonary_service ADD CONSTRAINT FK_C05E095CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_additional_info ADD CONSTRAINT FK_AAEC8DE4483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
        $this->addSql('ALTER TABLE service_dictionary_service ADD CONSTRAINT FK_F62BB94D7FE1E1BE FOREIGN KEY (service_dictionary_id) REFERENCES service_dictionary (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_dictionary_service ADD CONSTRAINT FK_F62BB94DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_open_hours ADD CONSTRAINT FK_7C29741D483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
        $this->addSql('ALTER TABLE company_service ADD CONSTRAINT FK_C1CF8005979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_service ADD CONSTRAINT FK_C1CF8005ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_address_addiotional_info DROP FOREIGN KEY FK_481EF63A483946E3');
        $this->addSql('ALTER TABLE province_dictionary DROP FOREIGN KEY FK_3044A8AB483946E3');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE company_address_addiotional_info');
        $this->addSql('DROP TABLE country_dictionary');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE province_dictionary');
        $this->addSql('ALTER TABLE user ADD company_id INT DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649989D9B62 ON user (slug)');
        $this->addSql('CREATE INDEX IDX_8D93D649979B1AD6 ON user (company_id)');
        $this->addSql('DROP INDEX UNIQ_2D1C7556989D9B62 ON company_address');
        $this->addSql('DROP INDEX IDX_2D1C75565CEB89F8 ON company_address');
        $this->addSql('ALTER TABLE company_address ADD post_code VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD street VARCHAR(255) DEFAULT NULL, ADD building_number VARCHAR(255) DEFAULT NULL, DROP country_dictionary_id, DROP name, DROP zip_code, DROP phone, DROP email, DROP slug, CHANGE city city VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_4FBF094FE946114A ON company');
        $this->addSql('DROP INDEX IDX_4FBF094F5CEB89F8 ON company');
        $this->addSql('ALTER TABLE company DROP province_id, DROP country_dictionary_id, DROP city, DROP phone, DROP email, DROP website, DROP zip_code');
    }
}

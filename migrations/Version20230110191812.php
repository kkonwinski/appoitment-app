<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110191812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_open_hours (id INT AUTO_INCREMENT NOT NULL, company_address_id INT NOT NULL, day_name VARCHAR(255) NOT NULL, open_from TIME NOT NULL, open_to TIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_7C29741D483946E3 (company_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_open_hours ADD CONSTRAINT FK_7C29741D483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_open_hours DROP FOREIGN KEY FK_7C29741D483946E3');
        $this->addSql('DROP TABLE company_open_hours');
    }
}

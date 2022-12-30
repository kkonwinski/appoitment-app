<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229184705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_address_service (company_address_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_F5895737483946E3 (company_address_id), INDEX IDX_F5895737ED5CA9E6 (service_id), PRIMARY KEY(company_address_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_address_service ADD CONSTRAINT FK_F5895737483946E3 FOREIGN KEY (company_address_id) REFERENCES company_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_address_service ADD CONSTRAINT FK_F5895737ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_address_service DROP FOREIGN KEY FK_F5895737483946E3');
        $this->addSql('ALTER TABLE company_address_service DROP FOREIGN KEY FK_F5895737ED5CA9E6');
        $this->addSql('DROP TABLE company_address_service');
    }
}

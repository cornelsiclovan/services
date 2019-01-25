<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181207133702 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_provider (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(5) NOT NULL, authorization_number VARCHAR(50) DEFAULT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, email VARCHAR(50) NOT NULL, telephone VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, street VARCHAR(50) NOT NULL, number VARCHAR(10) DEFAULT NULL, building VARCHAR(10) DEFAULT NULL, staircase VARCHAR(10) DEFAULT NULL, apartment VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_provider_service (service_provider_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_B6801F64C6C98E06 (service_provider_id), INDEX IDX_B6801F64ED5CA9E6 (service_id), PRIMARY KEY(service_provider_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_provider_service ADD CONSTRAINT FK_B6801F64C6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_provider_service ADD CONSTRAINT FK_B6801F64ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service_provider_service DROP FOREIGN KEY FK_B6801F64C6C98E06');
        $this->addSql('DROP TABLE service_provider');
        $this->addSql('DROP TABLE service_provider_service');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
    }
}

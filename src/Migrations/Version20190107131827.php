<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190107131827 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, street VARCHAR(50) NOT NULL, number VARCHAR(10) DEFAULT NULL, building VARCHAR(10) DEFAULT NULL, staircase VARCHAR(50) DEFAULT NULL, apartment VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE service_provider_service');
        $this->addSql('ALTER TABLE sub_service ADD service_provider_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service ADD CONSTRAINT FK_9E45C626C6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id)');
        $this->addSql('CREATE INDEX IDX_9E45C626C6C98E06 ON sub_service (service_provider_id)');
        $this->addSql('ALTER TABLE service_provider ADD user_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL, DROP type, DROP authorization_number, DROP name, DROP first_name, DROP email, DROP telephone, DROP country, DROP city, DROP street, DROP number, DROP building, DROP staircase, DROP apartment');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_provider ADD CONSTRAINT FK_6BB228A1ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BB228A1A76ED395 ON service_provider (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6BB228A1ED5CA9E6 ON service_provider (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1A76ED395');
        $this->addSql('CREATE TABLE service_provider_service (service_provider_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_B6801F64C6C98E06 (service_provider_id), INDEX IDX_B6801F64ED5CA9E6 (service_id), PRIMARY KEY(service_provider_id, service_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE service_provider_service ADD CONSTRAINT FK_B6801F64C6C98E06 FOREIGN KEY (service_provider_id) REFERENCES service_provider (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_provider_service ADD CONSTRAINT FK_B6801F64ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE service_provider DROP FOREIGN KEY FK_6BB228A1ED5CA9E6');
        $this->addSql('DROP INDEX UNIQ_6BB228A1A76ED395 ON service_provider');
        $this->addSql('DROP INDEX UNIQ_6BB228A1ED5CA9E6 ON service_provider');
        $this->addSql('ALTER TABLE service_provider ADD type VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, ADD authorization_number VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD first_name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD email VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD telephone VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD country VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD city VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD street VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, ADD number VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD building VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD staircase VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, ADD apartment VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, DROP user_id, DROP service_id');
        $this->addSql('ALTER TABLE sub_service DROP FOREIGN KEY FK_9E45C626C6C98E06');
        $this->addSql('DROP INDEX IDX_9E45C626C6C98E06 ON sub_service');
        $this->addSql('ALTER TABLE sub_service DROP service_provider_id, CHANGE service_id service_id INT DEFAULT NULL');
    }
}

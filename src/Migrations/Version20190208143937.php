<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190208143937 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_sub_service ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE number number VARCHAR(10) DEFAULT NULL, CHANGE building building VARCHAR(10) DEFAULT NULL, CHANGE staircase staircase VARCHAR(50) DEFAULT NULL, CHANGE apartment apartment VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_sub_service DROP city, DROP country, CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE number number VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE building building VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE staircase staircase VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apartment apartment VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
    }
}

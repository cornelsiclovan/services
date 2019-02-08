<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190208140539 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client_sub_service (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_9F0EE31DA76ED395 (user_id), INDEX IDX_9F0EE31DED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_sub_service_sub_service (client_sub_service_id INT NOT NULL, sub_service_id INT NOT NULL, INDEX IDX_E77DE030E05478A4 (client_sub_service_id), INDEX IDX_E77DE030C1973A2B (sub_service_id), PRIMARY KEY(client_sub_service_id, sub_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_service (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_9E45C626ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, street VARCHAR(50) NOT NULL, number VARCHAR(10) DEFAULT NULL, building VARCHAR(10) DEFAULT NULL, staircase VARCHAR(50) DEFAULT NULL, apartment VARCHAR(10) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', is_service_provider TINYINT(1) NOT NULL, is_client TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_sub_service (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, service_id INT DEFAULT NULL, INDEX IDX_375E0FB3A76ED395 (user_id), INDEX IDX_375E0FB3ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_sub_service_sub_service (user_sub_service_id INT NOT NULL, sub_service_id INT NOT NULL, INDEX IDX_BDFD10EAAA12E572 (user_sub_service_id), INDEX IDX_BDFD10EAC1973A2B (sub_service_id), PRIMARY KEY(user_sub_service_id, sub_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_sub_service ADD CONSTRAINT FK_9F0EE31DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client_sub_service ADD CONSTRAINT FK_9F0EE31DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE client_sub_service_sub_service ADD CONSTRAINT FK_E77DE030E05478A4 FOREIGN KEY (client_sub_service_id) REFERENCES client_sub_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_sub_service_sub_service ADD CONSTRAINT FK_E77DE030C1973A2B FOREIGN KEY (sub_service_id) REFERENCES sub_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_service ADD CONSTRAINT FK_9E45C626ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE user_sub_service ADD CONSTRAINT FK_375E0FB3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_sub_service ADD CONSTRAINT FK_375E0FB3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE user_sub_service_sub_service ADD CONSTRAINT FK_BDFD10EAAA12E572 FOREIGN KEY (user_sub_service_id) REFERENCES user_sub_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sub_service_sub_service ADD CONSTRAINT FK_BDFD10EAC1973A2B FOREIGN KEY (sub_service_id) REFERENCES sub_service (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_sub_service_sub_service DROP FOREIGN KEY FK_E77DE030E05478A4');
        $this->addSql('ALTER TABLE client_sub_service DROP FOREIGN KEY FK_9F0EE31DED5CA9E6');
        $this->addSql('ALTER TABLE sub_service DROP FOREIGN KEY FK_9E45C626ED5CA9E6');
        $this->addSql('ALTER TABLE user_sub_service DROP FOREIGN KEY FK_375E0FB3ED5CA9E6');
        $this->addSql('ALTER TABLE client_sub_service_sub_service DROP FOREIGN KEY FK_E77DE030C1973A2B');
        $this->addSql('ALTER TABLE user_sub_service_sub_service DROP FOREIGN KEY FK_BDFD10EAC1973A2B');
        $this->addSql('ALTER TABLE client_sub_service DROP FOREIGN KEY FK_9F0EE31DA76ED395');
        $this->addSql('ALTER TABLE user_sub_service DROP FOREIGN KEY FK_375E0FB3A76ED395');
        $this->addSql('ALTER TABLE user_sub_service_sub_service DROP FOREIGN KEY FK_BDFD10EAAA12E572');
        $this->addSql('DROP TABLE client_sub_service');
        $this->addSql('DROP TABLE client_sub_service_sub_service');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE sub_service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_sub_service');
        $this->addSql('DROP TABLE user_sub_service_sub_service');
    }
}

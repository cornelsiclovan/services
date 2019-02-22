<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214130235 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commment (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, client_sub_service_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_B8363E5CF675F31B (author_id), INDEX IDX_B8363E5CE05478A4 (client_sub_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commment ADD CONSTRAINT FK_B8363E5CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commment ADD CONSTRAINT FK_B8363E5CE05478A4 FOREIGN KEY (client_sub_service_id) REFERENCES client_sub_service (id)');
        $this->addSql('ALTER TABLE client_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE number number VARCHAR(10) DEFAULT NULL, CHANGE building building VARCHAR(10) DEFAULT NULL, CHANGE staircase staircase VARCHAR(50) DEFAULT NULL, CHANGE apartment apartment VARCHAR(10) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commment');
        $this->addSql('ALTER TABLE client_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE number number VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE building building VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE staircase staircase VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apartment apartment VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
    }
}

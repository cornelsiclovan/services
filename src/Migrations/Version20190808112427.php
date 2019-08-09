<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808112427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE password_reset_model (id INT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, new_password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL, CHANGE accepted_offer_id accepted_offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commment CHANGE author_id author_id INT DEFAULT NULL, CHANGE client_sub_service_id client_sub_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE url url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE password_reset_token_entity CHANGE user_id user_id INT DEFAULT NULL, CHANGE token token VARCHAR(40) DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE number number VARCHAR(10) DEFAULT NULL, CHANGE building building VARCHAR(10) DEFAULT NULL, CHANGE staircase staircase VARCHAR(50) DEFAULT NULL, CHANGE apartment apartment VARCHAR(10) DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(40) DEFAULT NULL, CHANGE password_change_date password_change_date INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE password_reset_model');
        $this->addSql('ALTER TABLE client_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL, CHANGE accepted_offer_id accepted_offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commment CHANGE author_id author_id INT DEFAULT NULL, CHANGE client_sub_service_id client_sub_service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image CHANGE url url VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE password_reset_token_entity CHANGE user_id user_id INT DEFAULT NULL, CHANGE token token VARCHAR(40) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE image_id image_id INT DEFAULT NULL, CHANGE first_name first_name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE number number VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE building building VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE staircase staircase VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apartment apartment VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE password_change_date password_change_date INT DEFAULT NULL, CHANGE confirmation_token confirmation_token VARCHAR(40) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_sub_service CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
    }
}

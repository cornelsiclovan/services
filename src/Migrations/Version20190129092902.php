<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129092902 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_sub_service (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_375E0FB3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_sub_service_sub_service (user_sub_service_id INT NOT NULL, sub_service_id INT NOT NULL, INDEX IDX_BDFD10EAAA12E572 (user_sub_service_id), INDEX IDX_BDFD10EAC1973A2B (sub_service_id), PRIMARY KEY(user_sub_service_id, sub_service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sub_service ADD CONSTRAINT FK_375E0FB3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_sub_service_sub_service ADD CONSTRAINT FK_BDFD10EAAA12E572 FOREIGN KEY (user_sub_service_id) REFERENCES user_sub_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sub_service_sub_service ADD CONSTRAINT FK_BDFD10EAC1973A2B FOREIGN KEY (sub_service_id) REFERENCES sub_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL, CHANGE service_provider_id service_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE service_provider CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT NULL, CHANGE number number VARCHAR(10) DEFAULT NULL, CHANGE building building VARCHAR(10) DEFAULT NULL, CHANGE staircase staircase VARCHAR(50) DEFAULT NULL, CHANGE apartment apartment VARCHAR(10) DEFAULT NULL, CHANGE service_provider service_provider TINYINT(1) DEFAULT NULL, CHANGE client client TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_sub_service_sub_service DROP FOREIGN KEY FK_BDFD10EAAA12E572');
        $this->addSql('DROP TABLE user_sub_service');
        $this->addSql('DROP TABLE user_sub_service_sub_service');
        $this->addSql('ALTER TABLE service_provider CHANGE user_id user_id INT DEFAULT NULL, CHANGE service_id service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_service CHANGE service_id service_id INT DEFAULT NULL, CHANGE service_provider_id service_provider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE number number VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE building building VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE staircase staircase VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE apartment apartment VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE service_provider service_provider TINYINT(1) DEFAULT \'NULL\', CHANGE client client TINYINT(1) DEFAULT \'NULL\'');
    }
}

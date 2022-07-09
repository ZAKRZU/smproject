<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709011923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brick_item (id INT AUTO_INCREMENT NOT NULL, no VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, category_id INT NOT NULL, alternate_no VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) DEFAULT NULL, thumbnail_url VARCHAR(255) DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, dim_x VARCHAR(255) DEFAULT NULL, dim_y VARCHAR(255) DEFAULT NULL, dim_z VARCHAR(255) DEFAULT NULL, year_released INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_obsolete TINYINT(1) DEFAULT NULL, language_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventory DROP item, DROP item_no, DROP item_name, DROP item_type, CHANGE item_category_id item_id INT NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36126F525E FOREIGN KEY (item_id) REFERENCES brick_item (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36126F525E ON inventory (item_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36126F525E');
        $this->addSql('DROP TABLE brick_item');
        $this->addSql('DROP INDEX IDX_B12D4A36126F525E ON inventory');
        $this->addSql('ALTER TABLE inventory ADD item JSON NOT NULL, ADD item_no VARCHAR(20) NOT NULL, ADD item_name VARCHAR(300) NOT NULL, ADD item_type VARCHAR(255) NOT NULL, CHANGE item_id item_category_id INT NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704142800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, item LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', item_no VARCHAR(20) NOT NULL, item_name VARCHAR(300) NOT NULL, item_type VARCHAR(255) NOT NULL, item_category_id INT NOT NULL, color_id INT NOT NULL, color_name VARCHAR(50) NOT NULL, quantity INT NOT NULL, new_or_used VARCHAR(1) NOT NULL, completeness VARCHAR(1) NOT NULL, unit_price NUMERIC(10, 4) NOT NULL, bind_id INT NOT NULL, description VARCHAR(255) NOT NULL, remarks VARCHAR(255) NOT NULL, bulk INT NOT NULL, is_retain TINYINT(1) NOT NULL, is_stock_room TINYINT(1) NOT NULL, stock_room_id INT NOT NULL, date_created DATETIME NOT NULL, my_cost NUMERIC(10, 4) NOT NULL, sale_rate INT NOT NULL, tier_quantity1 INT NOT NULL, tier_quantity2 INT NOT NULL, tier_quantity3 INT NOT NULL, tier_price1 NUMERIC(10, 4) NOT NULL, tier_price2 NUMERIC(10, 4) NOT NULL, tier_price3 NUMERIC(10, 4) NOT NULL, my_weight NUMERIC(10, 4) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inventory');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}

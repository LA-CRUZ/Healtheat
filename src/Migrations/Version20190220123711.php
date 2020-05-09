<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220123711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE intolerance (id INT AUTO_INCREMENT NOT NULL, gluten TINYINT(1) DEFAULT NULL, lactose TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergies (id INT AUTO_INCREMENT NOT NULL, arachides TINYINT(1) DEFAULT NULL, soja TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_regime (id INT AUTO_INCREMENT NOT NULL, vegan TINYINT(1) DEFAULT NULL, vegetarien TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_user DROP intolerance, DROP type_regime');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE intolerance');
        $this->addSql('DROP TABLE allergies');
        $this->addSql('DROP TABLE type_regime');
        $this->addSql('ALTER TABLE info_user ADD intolerance LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD type_regime VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}

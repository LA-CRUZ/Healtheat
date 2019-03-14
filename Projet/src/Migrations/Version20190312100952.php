<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312100952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE temps_effort_phy (id INT AUTO_INCREMENT NOT NULL, info_user_id INT NOT NULL, temps INT NOT NULL, INDEX IDX_D503A1CF25ABFA0B (info_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE temps_effort_phy ADD CONSTRAINT FK_D503A1CF25ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id)');
        $this->addSql('ALTER TABLE info_user DROP temps_activite_physique');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE temps_effort_phy');
        $this->addSql('ALTER TABLE info_user ADD temps_activite_physique INT DEFAULT NULL');
    }
}

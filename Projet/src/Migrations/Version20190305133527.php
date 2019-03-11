<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305133527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poids DROP FOREIGN KEY FK_D32E8E0D25ABFA0B');
        $this->addSql('DROP INDEX IDX_D32E8E0D25ABFA0B ON poids');
        $this->addSql('ALTER TABLE poids CHANGE info_user_id id_u INT NOT NULL');
        $this->addSql('ALTER TABLE info_user ADD poids INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE info_user DROP poids');
        $this->addSql('ALTER TABLE poids CHANGE id_u info_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE poids ADD CONSTRAINT FK_D32E8E0D25ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id)');
        $this->addSql('CREATE INDEX IDX_D32E8E0D25ABFA0B ON poids (info_user_id)');
    }
}

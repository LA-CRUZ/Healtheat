<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190329110208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE programmes CHANGE id_u utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE programmes ADD CONSTRAINT FK_3631FC3FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES info_user (id)');
        $this->addSql('CREATE INDEX IDX_3631FC3FFB88E14F ON programmes (utilisateur_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE programmes DROP FOREIGN KEY FK_3631FC3FFB88E14F');
        $this->addSql('DROP INDEX IDX_3631FC3FFB88E14F ON programmes');
        $this->addSql('ALTER TABLE programmes CHANGE utilisateur_id id_u INT NOT NULL');
    }
}

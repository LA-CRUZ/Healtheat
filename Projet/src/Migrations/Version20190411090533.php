<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411090533 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE prog_contenu (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_7997211262BB7AEE (programme_id), INDEX IDX_7997211289312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE prog_contenu ADD CONSTRAINT FK_7997211262BB7AEE FOREIGN KEY (programme_id) REFERENCES programmes (id)');
        $this->addSql('ALTER TABLE prog_contenu ADD CONSTRAINT FK_7997211289312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('DROP TABLE programmes_recette');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE programmes_recette (programmes_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_23870ABF89312FE9 (recette_id), INDEX IDX_23870ABFA0A1C920 (programmes_id), PRIMARY KEY(programmes_id, recette_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE programmes_recette ADD CONSTRAINT FK_23870ABF89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programmes_recette ADD CONSTRAINT FK_23870ABFA0A1C920 FOREIGN KEY (programmes_id) REFERENCES programmes (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE prog_contenu');
    }
}

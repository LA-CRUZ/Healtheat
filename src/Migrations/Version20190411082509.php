<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411082509 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE programmes_contenu');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE programmes_contenu (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_E3FE691062BB7AEE (programme_id), INDEX IDX_E3FE691089312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE programmes_contenu ADD CONSTRAINT FK_E3FE691062BB7AEE FOREIGN KEY (programme_id) REFERENCES programmes (id)');
        $this->addSql('ALTER TABLE programmes_contenu ADD CONSTRAINT FK_E3FE691089312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
    }
}

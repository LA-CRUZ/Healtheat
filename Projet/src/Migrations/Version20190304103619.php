<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304103619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poids (id INT AUTO_INCREMENT NOT NULL, poids DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user_poids (info_user_id INT NOT NULL, poids_id INT NOT NULL, INDEX IDX_692949F925ABFA0B (info_user_id), INDEX IDX_692949F9174FEEBA (poids_id), PRIMARY KEY(info_user_id, poids_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_user_poids ADD CONSTRAINT FK_692949F925ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_poids ADD CONSTRAINT FK_692949F9174FEEBA FOREIGN KEY (poids_id) REFERENCES poids (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user DROP poids');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE info_user_poids DROP FOREIGN KEY FK_692949F9174FEEBA');
        $this->addSql('DROP TABLE poids');
        $this->addSql('DROP TABLE info_user_poids');
        $this->addSql('ALTER TABLE info_user ADD poids INT DEFAULT NULL');
    }
}

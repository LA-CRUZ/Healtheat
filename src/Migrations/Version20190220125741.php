<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220125741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE intolerance (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user_intolerance (info_user_id INT NOT NULL, intolerance_id INT NOT NULL, INDEX IDX_8E7AF1CF25ABFA0B (info_user_id), INDEX IDX_8E7AF1CF844A8E38 (intolerance_id), PRIMARY KEY(info_user_id, intolerance_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user_allergie (info_user_id INT NOT NULL, allergie_id INT NOT NULL, INDEX IDX_B6CA91D625ABFA0B (info_user_id), INDEX IDX_B6CA91D67C86304A (allergie_id), PRIMARY KEY(info_user_id, allergie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_user_intolerance ADD CONSTRAINT FK_8E7AF1CF25ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_intolerance ADD CONSTRAINT FK_8E7AF1CF844A8E38 FOREIGN KEY (intolerance_id) REFERENCES intolerance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_allergie ADD CONSTRAINT FK_B6CA91D625ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_allergie ADD CONSTRAINT FK_B6CA91D67C86304A FOREIGN KEY (allergie_id) REFERENCES allergie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE info_user_intolerance DROP FOREIGN KEY FK_8E7AF1CF844A8E38');
        $this->addSql('ALTER TABLE info_user_allergie DROP FOREIGN KEY FK_B6CA91D67C86304A');
        $this->addSql('DROP TABLE intolerance');
        $this->addSql('DROP TABLE allergie');
        $this->addSql('DROP TABLE info_user_intolerance');
        $this->addSql('DROP TABLE info_user_allergie');
    }
}

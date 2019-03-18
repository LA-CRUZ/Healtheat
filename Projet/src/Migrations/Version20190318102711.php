<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318102711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inventaire_produit DROP FOREIGN KEY FK_CEBE96E1CE430A85');
        $this->addSql('ALTER TABLE inventaire_produit DROP FOREIGN KEY FK_CEBE96E1F347EFB');
        $this->addSql('ALTER TABLE recette_produit DROP FOREIGN KEY FK_EDDD365DF347EFB');
        $this->addSql('CREATE TABLE ingred_csv (id INT AUTO_INCREMENT NOT NULL, recette_id INT NOT NULL, ingredient_string VARCHAR(255) NOT NULL, INDEX IDX_AB00AE8F89312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, ingredient VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user_ingredient (info_user_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_26E408E525ABFA0B (info_user_id), INDEX IDX_26E408E5933FE08C (ingredient_id), PRIMARY KEY(info_user_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingred_csv ADD CONSTRAINT FK_AB00AE8F89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE info_user_ingredient ADD CONSTRAINT FK_26E408E525ABFA0B FOREIGN KEY (info_user_id) REFERENCES info_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_user_ingredient ADD CONSTRAINT FK_26E408E5933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE inventaire');
        $this->addSql('DROP TABLE inventaire_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE recette_produit');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE info_user_ingredient DROP FOREIGN KEY FK_26E408E5933FE08C');
        $this->addSql('CREATE TABLE inventaire (id INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE inventaire_produit (inventaire_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_CEBE96E1F347EFB (produit_id), INDEX IDX_CEBE96E1CE430A85 (inventaire_id), PRIMARY KEY(inventaire_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, kcal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE recette_produit (recette_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_EDDD365DF347EFB (produit_id), INDEX IDX_EDDD365D89312FE9 (recette_id), PRIMARY KEY(recette_id, produit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE inventaire_produit ADD CONSTRAINT FK_CEBE96E1CE430A85 FOREIGN KEY (inventaire_id) REFERENCES inventaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventaire_produit ADD CONSTRAINT FK_CEBE96E1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_produit ADD CONSTRAINT FK_EDDD365D89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recette_produit ADD CONSTRAINT FK_EDDD365DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ingred_csv');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE info_user_ingredient');
    }
}

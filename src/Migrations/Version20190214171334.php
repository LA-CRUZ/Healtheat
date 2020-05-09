<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190214171334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, ingredient LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', description LONGTEXT NOT NULL, kcal INT NOT NULL, temps_prep INT NOT NULL, temps_cuisson INT NOT NULL, appareil VARCHAR(255) NOT NULL, type_repas VARCHAR(255) NOT NULL, catégorie_repas VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire (id INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventaire_produit (inventaire_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_CEBE96E1CE430A85 (inventaire_id), INDEX IDX_CEBE96E1F347EFB (produit_id), PRIMARY KEY(inventaire_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, kcal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme_recette (programme_id INT NOT NULL, recette_id INT NOT NULL, INDEX IDX_92182E1B62BB7AEE (programme_id), INDEX IDX_92182E1B89312FE9 (recette_id), PRIMARY KEY(programme_id, recette_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, poids INT DEFAULT NULL, taille INT DEFAULT NULL, tour_taille INT DEFAULT NULL, tour_hanche INT DEFAULT NULL, temps_activite_physique INT DEFAULT NULL, intolerance LONGTEXT DEFAULT NULL, type_regime VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inventaire_produit ADD CONSTRAINT FK_CEBE96E1CE430A85 FOREIGN KEY (inventaire_id) REFERENCES inventaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inventaire_produit ADD CONSTRAINT FK_CEBE96E1F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_recette ADD CONSTRAINT FK_92182E1B62BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE programme_recette ADD CONSTRAINT FK_92182E1B89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE programme_recette DROP FOREIGN KEY FK_92182E1B89312FE9');
        $this->addSql('ALTER TABLE inventaire_produit DROP FOREIGN KEY FK_CEBE96E1CE430A85');
        $this->addSql('ALTER TABLE inventaire_produit DROP FOREIGN KEY FK_CEBE96E1F347EFB');
        $this->addSql('ALTER TABLE programme_recette DROP FOREIGN KEY FK_92182E1B62BB7AEE');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE inventaire');
        $this->addSql('DROP TABLE inventaire_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE programme_recette');
        $this->addSql('DROP TABLE info_user');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127160410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, id_pegi_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, date_parution DATE NOT NULL, INDEX IDX_3755B50D39C373A (id_pegi_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D39C373A FOREIGN KEY (id_pegi_id) REFERENCES pegi (id)');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (num_cat INT AUTO_INCREMENT NOT NULL, lib_cat VARCHAR(30) CHARACTER SET utf32 NOT NULL COLLATE `utf32_general_ci`, PRIMARY KEY(num_cat)) DEFAULT CHARACTER SET utf32 COLLATE `utf32_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE client (num_client INT AUTO_INCREMENT NOT NULL, nom_client VARCHAR(32) CHARACTER SET utf32 NOT NULL COLLATE `utf32_general_ci`, prenom_client VARCHAR(32) CHARACTER SET utf32 NOT NULL COLLATE `utf32_general_ci`, email_client VARCHAR(255) CHARACTER SET utf32 NOT NULL COLLATE `utf32_general_ci`, num_cat INT NOT NULL, num_ent INT DEFAULT NULL, INDEX fk_clientEntreprise (num_ent), INDEX fk_clientCategorie (num_cat), PRIMARY KEY(num_client)) DEFAULT CHARACTER SET utf32 COLLATE `utf32_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (num_cde INT AUTO_INCREMENT NOT NULL, date_cde DATE NOT NULL, num_client INT NOT NULL, montant_cde NUMERIC(10, 2) NOT NULL, INDEX num_client (num_client), PRIMARY KEY(num_cde)) DEFAULT CHARACTER SET utf32 COLLATE `utf32_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, opportunite_id INT DEFAULT NULL, client_id INT DEFAULT NULL, snservice VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, responsableducontrat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6034999319EB6921 (client_id), INDEX IDX_6034999380FBB128 (opportunite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D39C373A');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(40) NOT NULL');
    }
}

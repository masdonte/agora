<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127161834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, telephone VARCHAR(14) NOT NULL, email VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournoi_participant (tournoi_id INT NOT NULL, participant_id INT NOT NULL, INDEX IDX_9C531479F607770A (tournoi_id), INDEX IDX_9C5314799D1C3019 (participant_id), PRIMARY KEY(tournoi_id, participant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournoi_participant ADD CONSTRAINT FK_9C531479F607770A FOREIGN KEY (tournoi_id) REFERENCES tournoi (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournoi_participant ADD CONSTRAINT FK_9C5314799D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D391E226B');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D39C373A');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D4827B9B2');
        $this->addSql('DROP INDEX IDX_3755B50D39C373A ON jeux');
        $this->addSql('DROP INDEX IDX_3755B50D4827B9B2 ON jeux');
        $this->addSql('DROP INDEX IDX_3755B50D391E226B ON jeux');
        $this->addSql('ALTER TABLE jeux DROP id_pegi_id, DROP marque_id, DROP plateforme_id, DROP nom, DROP prix, DROP date_parution');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournoi_participant DROP FOREIGN KEY FK_9C531479F607770A');
        $this->addSql('ALTER TABLE tournoi_participant DROP FOREIGN KEY FK_9C5314799D1C3019');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE tournoi_participant');
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE jeux ADD id_pegi_id INT DEFAULT NULL, ADD marque_id INT DEFAULT NULL, ADD plateforme_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD date_parution DATE NOT NULL');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D39C373A FOREIGN KEY (id_pegi_id) REFERENCES pegi (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3755B50D39C373A ON jeux (id_pegi_id)');
        $this->addSql('CREATE INDEX IDX_3755B50D4827B9B2 ON jeux (marque_id)');
        $this->addSql('CREATE INDEX IDX_3755B50D391E226B ON jeux (plateforme_id)');
    }
}

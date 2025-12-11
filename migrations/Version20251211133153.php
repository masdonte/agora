<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211133153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE jeux ADD id_pegi_id INT DEFAULT NULL, ADD marque_id INT DEFAULT NULL, ADD plateforme_id INT DEFAULT NULL, ADD nom VARCHAR(255) NOT NULL, ADD prix DOUBLE PRECISION NOT NULL, ADD date_parution DATE NOT NULL');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D39C373A FOREIGN KEY (id_pegi_id) REFERENCES pegi (id)');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)');
        $this->addSql('CREATE INDEX IDX_3755B50D39C373A ON jeux (id_pegi_id)');
        $this->addSql('CREATE INDEX IDX_3755B50D4827B9B2 ON jeux (marque_id)');
        $this->addSql('CREATE INDEX IDX_3755B50D391E226B ON jeux (plateforme_id)');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat_tournois CHANGE libelle libelle VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D39C373A');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D4827B9B2');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D391E226B');
        $this->addSql('DROP INDEX IDX_3755B50D39C373A ON jeux');
        $this->addSql('DROP INDEX IDX_3755B50D4827B9B2 ON jeux');
        $this->addSql('DROP INDEX IDX_3755B50D391E226B ON jeux');
        $this->addSql('ALTER TABLE jeux DROP id_pegi_id, DROP marque_id, DROP plateforme_id, DROP nom, DROP prix, DROP date_parution');
        $this->addSql('ALTER TABLE tournoi CHANGE libelle libelle VARCHAR(40) NOT NULL');
    }
}

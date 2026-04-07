<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407122938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reconnaissance ADD reconnaissance_tournoi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reconnaissance ADD CONSTRAINT FK_8D79420D50A9F86D FOREIGN KEY (reconnaissance_tournoi_id) REFERENCES cat_tournois (id)');
        $this->addSql('CREATE INDEX IDX_8D79420D50A9F86D ON reconnaissance (reconnaissance_tournoi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reconnaissance DROP FOREIGN KEY FK_8D79420D50A9F86D');
        $this->addSql('DROP INDEX IDX_8D79420D50A9F86D ON reconnaissance');
        $this->addSql('ALTER TABLE reconnaissance DROP reconnaissance_tournoi_id');
    }
}

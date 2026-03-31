<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260330185200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre ADD rue_membre VARCHAR(255) DEFAULT NULL, ADD cp_membre VARCHAR(10) DEFAULT NULL, CHANGE mail_membre mail_membre VARCHAR(100) NOT NULL, CHANGE ville_membre ville_membre VARCHAR(100) DEFAULT NULL, CHANGE prenommembre prenom_membre VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membre DROP rue_membre, DROP cp_membre, CHANGE mail_membre mail_membre VARCHAR(70) NOT NULL, CHANGE ville_membre ville_membre VARCHAR(70) NOT NULL, CHANGE prenom_membre prenommembre VARCHAR(20) NOT NULL');
    }
}

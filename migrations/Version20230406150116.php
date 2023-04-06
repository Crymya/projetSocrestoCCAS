<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406150116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, etiquette_id INT NOT NULL, nom_stockage VARCHAR(255) NOT NULL, INDEX IDX_D8698A767BD2EA57 (etiquette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etiquette (id INT AUTO_INCREMENT NOT NULL, editeur_id INT NOT NULL, nom_produit VARCHAR(255) NOT NULL, temperature DOUBLE PRECISION NOT NULL, jour_utilise DATE NOT NULL, dlc DATE NOT NULL, INDEX IDX_1E0E195A3375BD21 (editeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767BD2EA57 FOREIGN KEY (etiquette_id) REFERENCES etiquette (id)');
        $this->addSql('ALTER TABLE etiquette ADD CONSTRAINT FK_1E0E195A3375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A767BD2EA57');
        $this->addSql('ALTER TABLE etiquette DROP FOREIGN KEY FK_1E0E195A3375BD21');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE etiquette');
    }
}

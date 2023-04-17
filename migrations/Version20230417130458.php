<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417130458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tache (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache_prevue (id INT AUTO_INCREMENT NOT NULL, periode_id INT NOT NULL, zone_id INT NOT NULL, tache_id INT NOT NULL, INDEX IDX_E61A2B8BF384C1CF (periode_id), INDEX IDX_E61A2B8B9F2C3FAB (zone_id), INDEX IDX_E61A2B8BD2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache_realisee (id INT AUTO_INCREMENT NOT NULL, travail_id INT NOT NULL, tache_id INT NOT NULL, editeur_id INT DEFAULT NULL, realisee TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_43B919FDEEFE7EA9 (travail_id), INDEX IDX_43B919FDD2235D39 (tache_id), INDEX IDX_43B919FD3375BD21 (editeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE travail (id INT AUTO_INCREMENT NOT NULL, zone_id INT NOT NULL, periode_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_90897ABB9F2C3FAB (zone_id), INDEX IDX_90897ABBF384C1CF (periode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_periode (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tache_prevue ADD CONSTRAINT FK_E61A2B8BF384C1CF FOREIGN KEY (periode_id) REFERENCES type_periode (id)');
        $this->addSql('ALTER TABLE tache_prevue ADD CONSTRAINT FK_E61A2B8B9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE tache_prevue ADD CONSTRAINT FK_E61A2B8BD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE tache_realisee ADD CONSTRAINT FK_43B919FDEEFE7EA9 FOREIGN KEY (travail_id) REFERENCES travail (id)');
        $this->addSql('ALTER TABLE tache_realisee ADD CONSTRAINT FK_43B919FDD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id)');
        $this->addSql('ALTER TABLE tache_realisee ADD CONSTRAINT FK_43B919FD3375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
        $this->addSql('ALTER TABLE travail ADD CONSTRAINT FK_90897ABB9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE travail ADD CONSTRAINT FK_90897ABBF384C1CF FOREIGN KEY (periode_id) REFERENCES type_periode (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache_prevue DROP FOREIGN KEY FK_E61A2B8BF384C1CF');
        $this->addSql('ALTER TABLE tache_prevue DROP FOREIGN KEY FK_E61A2B8B9F2C3FAB');
        $this->addSql('ALTER TABLE tache_prevue DROP FOREIGN KEY FK_E61A2B8BD2235D39');
        $this->addSql('ALTER TABLE tache_realisee DROP FOREIGN KEY FK_43B919FDEEFE7EA9');
        $this->addSql('ALTER TABLE tache_realisee DROP FOREIGN KEY FK_43B919FDD2235D39');
        $this->addSql('ALTER TABLE tache_realisee DROP FOREIGN KEY FK_43B919FD3375BD21');
        $this->addSql('ALTER TABLE travail DROP FOREIGN KEY FK_90897ABB9F2C3FAB');
        $this->addSql('ALTER TABLE travail DROP FOREIGN KEY FK_90897ABBF384C1CF');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE tache_prevue');
        $this->addSql('DROP TABLE tache_realisee');
        $this->addSql('DROP TABLE travail');
        $this->addSql('DROP TABLE type_periode');
        $this->addSql('DROP TABLE zone');
    }
}

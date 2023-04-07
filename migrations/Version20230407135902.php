<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407135902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lieu (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_des_taches (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, periodicite_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_42EAF6176AB213CC (lieu_id), INDEX IDX_42EAF6172928752A (periodicite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodicite (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, periode VARCHAR(255) NOT NULL, recurrence INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tache_realise (id INT AUTO_INCREMENT NOT NULL, editeur_id INT NOT NULL, tache_id INT NOT NULL, moment DATETIME NOT NULL, INDEX IDX_DF9AE72B3375BD21 (editeur_id), INDEX IDX_DF9AE72BD2235D39 (tache_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_des_taches ADD CONSTRAINT FK_42EAF6176AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE liste_des_taches ADD CONSTRAINT FK_42EAF6172928752A FOREIGN KEY (periodicite_id) REFERENCES periodicite (id)');
        $this->addSql('ALTER TABLE tache_realise ADD CONSTRAINT FK_DF9AE72B3375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
        $this->addSql('ALTER TABLE tache_realise ADD CONSTRAINT FK_DF9AE72BD2235D39 FOREIGN KEY (tache_id) REFERENCES liste_des_taches (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_des_taches DROP FOREIGN KEY FK_42EAF6176AB213CC');
        $this->addSql('ALTER TABLE liste_des_taches DROP FOREIGN KEY FK_42EAF6172928752A');
        $this->addSql('ALTER TABLE tache_realise DROP FOREIGN KEY FK_DF9AE72B3375BD21');
        $this->addSql('ALTER TABLE tache_realise DROP FOREIGN KEY FK_DF9AE72BD2235D39');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE liste_des_taches');
        $this->addSql('DROP TABLE periodicite');
        $this->addSql('DROP TABLE tache_realise');
    }
}

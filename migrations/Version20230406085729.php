<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230406085729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE editeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, 
                            prenom VARCHAR(255) NOT NULL, actif TINYINT(1) NOT NULL, 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, 
                            temp_max INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temperature (id INT AUTO_INCREMENT NOT NULL, materiel_id INT NOT NULL, 
                            editeur_id INT NOT NULL, valeur DOUBLE PRECISION NOT NULL, date_controle DATETIME NOT NULL, 
                            INDEX IDX_BE4E2A6C16880AAF (materiel_id), INDEX IDX_BE4E2A6C3375BD21 (editeur_id), 
                            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE temperature ADD CONSTRAINT FK_BE4E2A6C16880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE temperature ADD CONSTRAINT FK_BE4E2A6C3375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temperature DROP FOREIGN KEY FK_BE4E2A6C16880AAF');
        $this->addSql('ALTER TABLE temperature DROP FOREIGN KEY FK_BE4E2A6C3375BD21');
        $this->addSql('DROP TABLE editeur');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE temperature');
    }
}

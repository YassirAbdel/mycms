<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309151653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, langue VARCHAR(255) DEFAULT NULL, commentaire LONGTEXT DEFAULT NULL, personne LONGTEXT DEFAULT NULL, oeuvre LONGTEXT DEFAULT NULL, organisme LONGTEXT DEFAULT NULL, lieu LONGTEXT DEFAULT NULL, descripteur LONGTEXT DEFAULT NULL, analyse TINYINT(1) DEFAULT NULL, droits TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, auteur VARCHAR(255) DEFAULT NULL, responsable VARCHAR(255) NOT NULL, editeur LONGTEXT NOT NULL, lieuedition VARCHAR(255) NOT NULL, annee_edition VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, pagination VARCHAR(255) NOT NULL, collection VARCHAR(255) NOT NULL, auteur_secondaire LONGTEXT NOT NULL, annee_stat INT NOT NULL, per_histo VARCHAR(255) NOT NULL, orig_doc VARCHAR(255) NOT NULL, copy_right VARCHAR(255) NOT NULL, support VARCHAR(255) NOT NULL, couleur VARCHAR(255) NOT NULL, format VARCHAR(255) NOT NULL, format_file VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, nb_files VARCHAR(255) NOT NULL, cote VARCHAR(255) NOT NULL, sup_num VARCHAR(255) NOT NULL, loca_supnum VARCHAR(255) NOT NULL, cote_num VARCHAR(255) NOT NULL, url_imag LONGTEXT NOT NULL, url_pdf LONGTEXT NOT NULL, url_audio LONGTEXT NOT NULL, num_video VARCHAR(255) NOT NULL, url_doc VARCHAR(255) NOT NULL, res_edit VARCHAR(255) NOT NULL, lecteur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ressource');
        $this->addSql('ALTER TABLE dossier CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sousrubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

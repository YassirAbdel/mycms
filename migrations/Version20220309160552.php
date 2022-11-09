<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309160552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ressource CHANGE responsable responsable VARCHAR(255) DEFAULT NULL, CHANGE editeur editeur LONGTEXT DEFAULT NULL, CHANGE lieuedition lieuedition VARCHAR(255) DEFAULT NULL, CHANGE annee_edition annee_edition VARCHAR(25) DEFAULT NULL, CHANGE isbn isbn VARCHAR(255) DEFAULT NULL, CHANGE pagination pagination VARCHAR(255) DEFAULT NULL, CHANGE collection collection VARCHAR(255) DEFAULT NULL, CHANGE auteur_secondaire auteur_secondaire LONGTEXT DEFAULT NULL, CHANGE annee_stat annee_stat INT DEFAULT NULL, CHANGE per_histo per_histo VARCHAR(255) DEFAULT NULL, CHANGE orig_doc orig_doc VARCHAR(255) DEFAULT NULL, CHANGE copy_right copy_right VARCHAR(255) DEFAULT NULL, CHANGE support support VARCHAR(255) DEFAULT NULL, CHANGE couleur couleur VARCHAR(255) DEFAULT NULL, CHANGE format format VARCHAR(255) DEFAULT NULL, CHANGE format_file format_file VARCHAR(255) DEFAULT NULL, CHANGE duree duree VARCHAR(255) DEFAULT NULL, CHANGE nb_files nb_files VARCHAR(255) DEFAULT NULL, CHANGE cote cote VARCHAR(255) DEFAULT NULL, CHANGE sup_num sup_num VARCHAR(255) DEFAULT NULL, CHANGE loca_supnum loca_supnum VARCHAR(255) DEFAULT NULL, CHANGE cote_num cote_num VARCHAR(255) DEFAULT NULL, CHANGE url_imag url_imag LONGTEXT DEFAULT NULL, CHANGE url_pdf url_pdf LONGTEXT DEFAULT NULL, CHANGE url_audio url_audio LONGTEXT DEFAULT NULL, CHANGE lecteur lecteur INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ressource CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE langue langue VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE personne personne LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE oeuvre oeuvre LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE organisme organisme LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripteur descripteur LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur auteur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable responsable VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE editeur editeur LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieuedition lieuedition VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE annee_edition annee_edition VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE isbn isbn VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pagination pagination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE collection collection VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur_secondaire auteur_secondaire LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE annee_stat annee_stat INT NOT NULL, CHANGE per_histo per_histo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE orig_doc orig_doc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copy_right copy_right VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE support support VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE couleur couleur VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format format VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format_file format_file VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree duree VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nb_files nb_files VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote cote VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sup_num sup_num VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE loca_supnum loca_supnum VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote_num cote_num VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_imag url_imag LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_pdf url_pdf LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_audio url_audio LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_video num_video VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_doc url_doc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_edit res_edit VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lecteur lecteur INT NOT NULL');
        $this->addSql('ALTER TABLE rubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sousrubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908113123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ressource CHANGE folder_front folder_front TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE soustitre soustitre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name image_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE collectioncnd CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE presentation presentation LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name image_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE dossier CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name image_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ressource CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE langue langue VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE personne personne LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE oeuvre oeuvre LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE organisme organisme LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripteur descripteur LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur auteur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable responsable VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE editeur editeur LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieuedition lieuedition VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE annee_edition annee_edition VARCHAR(25) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE isbn isbn VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pagination pagination VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE collection collection VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur_secondaire auteur_secondaire LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE per_histo per_histo VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE orig_doc orig_doc VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copy_right copy_right VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE support support VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE couleur couleur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format format VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format_file format_file VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree duree VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nb_files nb_files VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote cote VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sup_num sup_num VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE loca_supnum loca_supnum VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote_num cote_num VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_imag url_imag LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_pdf url_pdf LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_audio url_audio LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_video num_video VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_doc url_doc VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_edit res_edit VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE reference_cadic reference_cadic VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur_moral auteur_moral VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable_edition responsable_edition VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE folder_front folder_front TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE rubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE souscollectioncnd CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE presentation presentation LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name image_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sousrubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE texte CHANGE titre titre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contenu contenu LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309152307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ressource_sousrubrique (ressource_id INT NOT NULL, sousrubrique_id INT NOT NULL, INDEX IDX_3739FF40FC6CD52A (ressource_id), INDEX IDX_3739FF40BEE02DA1 (sousrubrique_id), PRIMARY KEY(ressource_id, sousrubrique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ressource_sousrubrique ADD CONSTRAINT FK_3739FF40FC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource_sousrubrique ADD CONSTRAINT FK_3739FF40BEE02DA1 FOREIGN KEY (sousrubrique_id) REFERENCES sousrubrique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource ADD rubriques_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544589A0FBB FOREIGN KEY (rubriques_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_939F4544589A0FBB ON ressource (rubriques_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ressource_sousrubrique');
        $this->addSql('ALTER TABLE dossier CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544589A0FBB');
        $this->addSql('DROP INDEX IDX_939F4544589A0FBB ON ressource');
        $this->addSql('ALTER TABLE ressource DROP rubriques_id, CHANGE type type VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE langue langue VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE personne personne LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE oeuvre oeuvre LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE organisme organisme LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieu lieu LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE descripteur descripteur LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur auteur VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE responsable responsable VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE editeur editeur LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE lieuedition lieuedition VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE annee_edition annee_edition VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE isbn isbn VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE pagination pagination VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE collection collection VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE auteur_secondaire auteur_secondaire LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE per_histo per_histo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE orig_doc orig_doc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE copy_right copy_right VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE support support VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE couleur couleur VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format format VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE format_file format_file VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE duree duree VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nb_files nb_files VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote cote VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sup_num sup_num VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE loca_supnum loca_supnum VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cote_num cote_num VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_imag url_imag LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_pdf url_pdf LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_audio url_audio LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE num_video num_video VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE url_doc url_doc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE res_edit res_edit VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE rubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sousrubrique CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE resume resume LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401081910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, nb_places_maxi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_inscription (atelier_id INT NOT NULL, inscription_id INT NOT NULL, INDEX IDX_20EC8DC882E2CF35 (atelier_id), INDEX IDX_20EC8DC85DAC5993 (inscription_id), PRIMARY KEY(atelier_id, inscription_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_theme (atelier_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_AEB6D34382E2CF35 (atelier_id), INDEX IDX_AEB6D34359027487 (theme_id), PRIMARY KEY(atelier_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_chambre (id INT AUTO_INCREMENT NOT NULL, libelle_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(255) NOT NULL, vile VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, cp VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, date_inscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_5E90F6D6F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_nuite (inscription_id INT NOT NULL, nuite_id INT NOT NULL, INDEX IDX_DF05E3585DAC5993 (inscription_id), INDEX IDX_DF05E358A84291E2 (nuite_id), PRIMARY KEY(inscription_id, nuite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, la_qualite_id INT NOT NULL, club_id INT NOT NULL, qualite_id INT NOT NULL, compte_id INT DEFAULT NULL, num_licence VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_3B7556128635C1A4 (la_qualite_id), INDEX IDX_3B75561261190A32 (club_id), INDEX IDX_3B755612A6338570 (qualite_id), UNIQUE INDEX UNIQ_3B755612F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nuite (id INT AUTO_INCREMENT NOT NULL, proposer_id INT NOT NULL, date_nuitee DATE NOT NULL, INDEX IDX_8D4CB715B13FA634 (proposer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposer (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, categorie_chambre_id INT NOT NULL, tarif_nuite INT NOT NULL, INDEX IDX_21866C153243BB18 (hotel_id), INDEX IDX_21866C155DEB5F8 (categorie_chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qualite (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restauration (id INT AUTO_INCREMENT NOT NULL, inscription_id INT DEFAULT NULL, date_restauration DATE NOT NULL, type_repas VARCHAR(255) NOT NULL, INDEX IDX_898B1EF15DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, num_licence VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649D8A9FCA1 (num_licence), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacation (id INT AUTO_INCREMENT NOT NULL, atelier_id INT DEFAULT NULL, date_heure_debut DATETIME NOT NULL, date_heure_fin DATETIME NOT NULL, INDEX IDX_E3DADF7582E2CF35 (atelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC882E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_inscription ADD CONSTRAINT FK_20EC8DC85DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_theme ADD CONSTRAINT FK_AEB6D34382E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE atelier_theme ADD CONSTRAINT FK_AEB6D34359027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6F2C56620 FOREIGN KEY (compte_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE inscription_nuite ADD CONSTRAINT FK_DF05E3585DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_nuite ADD CONSTRAINT FK_DF05E358A84291E2 FOREIGN KEY (nuite_id) REFERENCES nuite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556128635C1A4 FOREIGN KEY (la_qualite_id) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B75561261190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612A6338570 FOREIGN KEY (qualite_id) REFERENCES qualite (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612F2C56620 FOREIGN KEY (compte_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE nuite ADD CONSTRAINT FK_8D4CB715B13FA634 FOREIGN KEY (proposer_id) REFERENCES proposer (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C153243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE proposer ADD CONSTRAINT FK_21866C155DEB5F8 FOREIGN KEY (categorie_chambre_id) REFERENCES categorie_chambre (id)');
        $this->addSql('ALTER TABLE restauration ADD CONSTRAINT FK_898B1EF15DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE vacation ADD CONSTRAINT FK_E3DADF7582E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC882E2CF35');
        $this->addSql('ALTER TABLE atelier_theme DROP FOREIGN KEY FK_AEB6D34382E2CF35');
        $this->addSql('ALTER TABLE vacation DROP FOREIGN KEY FK_E3DADF7582E2CF35');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C155DEB5F8');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B75561261190A32');
        $this->addSql('ALTER TABLE proposer DROP FOREIGN KEY FK_21866C153243BB18');
        $this->addSql('ALTER TABLE atelier_inscription DROP FOREIGN KEY FK_20EC8DC85DAC5993');
        $this->addSql('ALTER TABLE inscription_nuite DROP FOREIGN KEY FK_DF05E3585DAC5993');
        $this->addSql('ALTER TABLE restauration DROP FOREIGN KEY FK_898B1EF15DAC5993');
        $this->addSql('ALTER TABLE inscription_nuite DROP FOREIGN KEY FK_DF05E358A84291E2');
        $this->addSql('ALTER TABLE nuite DROP FOREIGN KEY FK_8D4CB715B13FA634');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556128635C1A4');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612A6338570');
        $this->addSql('ALTER TABLE atelier_theme DROP FOREIGN KEY FK_AEB6D34359027487');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6F2C56620');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612F2C56620');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE atelier_inscription');
        $this->addSql('DROP TABLE atelier_theme');
        $this->addSql('DROP TABLE categorie_chambre');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_nuite');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE nuite');
        $this->addSql('DROP TABLE proposer');
        $this->addSql('DROP TABLE qualite');
        $this->addSql('DROP TABLE restauration');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vacation');
    }
}

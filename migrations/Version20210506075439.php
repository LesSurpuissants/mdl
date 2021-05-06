<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506075439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE club CHANGE vile ville VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556128635C1A4');
        $this->addSql('DROP INDEX IDX_3B7556128635C1A4 ON licencie');
        $this->addSql('ALTER TABLE licencie ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse1 VARCHAR(255) NOT NULL, ADD adresse2 VARCHAR(255) DEFAULT NULL, ADD cp VARCHAR(6) NOT NULL, ADD ville VARCHAR(70) NOT NULL, ADD tel VARCHAR(14) NOT NULL, ADD date_adhesion DATE NOT NULL, DROP la_qualite_id');
        $this->addSql('ALTER TABLE qualite ADD libelle VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE club CHANGE ville vile VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE licencie ADD la_qualite_id INT NOT NULL, DROP nom, DROP prenom, DROP adresse1, DROP adresse2, DROP cp, DROP ville, DROP tel, DROP date_adhesion');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556128635C1A4 FOREIGN KEY (la_qualite_id) REFERENCES qualite (id)');
        $this->addSql('CREATE INDEX IDX_3B7556128635C1A4 ON licencie (la_qualite_id)');
        $this->addSql('ALTER TABLE qualite DROP libelle');
    }
}

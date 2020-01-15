<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115114801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stage_theme (stage_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_17D255CC2298D193 (stage_id), INDEX IDX_17D255CC59027487 (theme_id), PRIMARY KEY(stage_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage_mot_cle (stage_id INT NOT NULL, mot_cle_id INT NOT NULL, INDEX IDX_256B92672298D193 (stage_id), INDEX IDX_256B9267FE94535C (mot_cle_id), PRIMARY KEY(stage_id, mot_cle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, adresse VARCHAR(255) NOT NULL, adresse_suite VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, continent VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, INDEX IDX_C35F081694936862 (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, est_privee TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mot_cle (id INT AUTO_INCREMENT NOT NULL, mot_cle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, pere_id INT DEFAULT NULL, theme VARCHAR(255) NOT NULL, INDEX IDX_9775E708E14A9070 (pere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage_theme ADD CONSTRAINT FK_17D255CC2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_theme ADD CONSTRAINT FK_17D255CC59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_mot_cle ADD CONSTRAINT FK_256B92672298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_mot_cle ADD CONSTRAINT FK_256B9267FE94535C FOREIGN KEY (mot_cle_id) REFERENCES mot_cle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F081694936862 FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708E14A9070 FOREIGN KEY (pere_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE stage ADD adresse_id INT NOT NULL, CHANGE sujet sujet VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936960D96D09 FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_C27C936960D96D09 ON stage (adresse_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C936960D96D09');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F081694936862');
        $this->addSql('ALTER TABLE stage_mot_cle DROP FOREIGN KEY FK_256B9267FE94535C');
        $this->addSql('ALTER TABLE stage_theme DROP FOREIGN KEY FK_17D255CC59027487');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708E14A9070');
        $this->addSql('DROP TABLE stage_theme');
        $this->addSql('DROP TABLE stage_mot_cle');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE mot_cle');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP INDEX IDX_C27C936960D96D09 ON stage');
        $this->addSql('ALTER TABLE stage DROP adresse_id, CHANGE sujet sujet VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

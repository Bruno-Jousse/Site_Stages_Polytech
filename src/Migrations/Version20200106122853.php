<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106122853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(500) NOT NULL, intitule VARCHAR(255) NOT NULL, annee INT NOT NULL, duree_jours INT NOT NULL, est_gratifie TINYINT(1) NOT NULL, gratification INT DEFAULT NULL, nom_etud VARCHAR(255) NOT NULL, prenom_etud VARCHAR(255) NOT NULL, contrat_pro TINYINT(1) NOT NULL, nom_tuteur_ent VARCHAR(255) NOT NULL, prenom_tuteur_ent VARCHAR(255) NOT NULL, tel_tuteur_ent VARCHAR(255) DEFAULT NULL, mail_visible TINYINT(1) NOT NULL, mail_tuteur_ent VARCHAR(255) NOT NULL, commentaire VARCHAR(1023) DEFAULT NULL, recap VARCHAR(500) DEFAULT NULL, embauche TINYINT(1) NOT NULL, promo INT NOT NULL, annee_form INT NOT NULL, departement INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE stage');
    }
}

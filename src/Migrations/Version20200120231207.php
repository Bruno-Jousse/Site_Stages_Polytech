<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200120231207 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F081694936862');
        $this->addSql('DROP INDEX idx_c35f081694936862 ON adresse');
        $this->addSql('CREATE INDEX IDX_C35F0816A4AEAFEA ON adresse (entreprise_id)');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F081694936862 FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C936960D96D09');
        $this->addSql('ALTER TABLE stage ADD entreprise_id INT NOT NULL');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_C27C9369A4AEAFEA ON stage (entreprise_id)');
        $this->addSql('DROP INDEX idx_c27c936960d96d09 ON stage');
        $this->addSql('CREATE INDEX IDX_C27C93694DE7DC5C ON stage (adresse_id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C936960D96D09 FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E708E14A9070');
        $this->addSql('DROP INDEX idx_9775e708e14a9070 ON theme');
        $this->addSql('CREATE INDEX IDX_9775E7083FD73900 ON theme (pere_id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E708E14A9070 FOREIGN KEY (pere_id) REFERENCES theme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816A4AEAFEA');
        $this->addSql('DROP INDEX idx_c35f0816a4aeafea ON adresse');
        $this->addSql('CREATE INDEX IDX_C35F081694936862 ON adresse (entreprise_id)');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A4AEAFEA');
        $this->addSql('DROP INDEX IDX_C27C9369A4AEAFEA ON stage');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93694DE7DC5C');
        $this->addSql('ALTER TABLE stage DROP entreprise_id');
        $this->addSql('DROP INDEX idx_c27c93694de7dc5c ON stage');
        $this->addSql('CREATE INDEX IDX_C27C936960D96D09 ON stage (adresse_id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93694DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E7083FD73900');
        $this->addSql('DROP INDEX idx_9775e7083fd73900 ON theme');
        $this->addSql('CREATE INDEX IDX_9775E708E14A9070 ON theme (pere_id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E7083FD73900 FOREIGN KEY (pere_id) REFERENCES theme (id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108125547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCFA57B6E2');
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFC1E77BAF4');
        $this->addSql('DROP INDEX IDX_6EDABEFCFA57B6E2 ON form_reponse');
        $this->addSql('DROP INDEX IDX_6EDABEFC1E77BAF4 ON form_reponse');
        $this->addSql('ALTER TABLE form_reponse ADD negociateur_id INT NOT NULL, DROP form_template_id_id, DROP negociateur_id_id');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCE58C74A8 FOREIGN KEY (negociateur_id) REFERENCES negociateur (id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCE58C74A8 ON form_reponse (negociateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCE58C74A8');
        $this->addSql('DROP INDEX IDX_6EDABEFCE58C74A8 ON form_reponse');
        $this->addSql('ALTER TABLE form_reponse ADD negociateur_id_id INT NOT NULL, CHANGE negociateur_id form_template_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCFA57B6E2 FOREIGN KEY (form_template_id_id) REFERENCES form_template (id)');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFC1E77BAF4 FOREIGN KEY (negociateur_id_id) REFERENCES negociateur (id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCFA57B6E2 ON form_reponse (form_template_id_id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFC1E77BAF4 ON form_reponse (negociateur_id_id)');
    }
}

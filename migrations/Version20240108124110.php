<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108124110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form_reponse (id INT AUTO_INCREMENT NOT NULL, form_template_id INT NOT NULL, form_template_id_id INT NOT NULL, INDEX IDX_6EDABEFCF2B19FA9 (form_template_id), INDEX IDX_6EDABEFCFA57B6E2 (form_template_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCF2B19FA9 FOREIGN KEY (form_template_id) REFERENCES form_template (id)');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCFA57B6E2 FOREIGN KEY (form_template_id_id) REFERENCES form_template (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCF2B19FA9');
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCFA57B6E2');
        $this->addSql('DROP TABLE form_reponse');
    }
}

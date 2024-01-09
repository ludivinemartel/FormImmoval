<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215141222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_question ADD form_template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE form_question ADD CONSTRAINT FK_7CDCC0AF2B19FA9 FOREIGN KEY (form_template_id) REFERENCES form_template (id)');
        $this->addSql('CREATE INDEX IDX_7CDCC0AF2B19FA9 ON form_question (form_template_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_question DROP FOREIGN KEY FK_7CDCC0AF2B19FA9');
        $this->addSql('DROP INDEX IDX_7CDCC0AF2B19FA9 ON form_question');
        $this->addSql('ALTER TABLE form_question DROP form_template_id');
    }
}

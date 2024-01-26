<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117091242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_form_template ADD form_template_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users_form_template ADD CONSTRAINT FK_2FBF92CAF2B19FA9 FOREIGN KEY (form_template_id) REFERENCES form_template (id)');
        $this->addSql('CREATE INDEX IDX_2FBF92CAF2B19FA9 ON users_form_template (form_template_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_form_template DROP FOREIGN KEY FK_2FBF92CAF2B19FA9');
        $this->addSql('DROP INDEX IDX_2FBF92CAF2B19FA9 ON users_form_template');
        $this->addSql('ALTER TABLE users_form_template DROP form_template_id');
    }
}

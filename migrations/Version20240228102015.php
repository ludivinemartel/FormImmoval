<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228102015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_question ADD checkbox_field TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE form_reponse DROP notetaking');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_question DROP checkbox_field');
        $this->addSql('ALTER TABLE form_reponse ADD notetaking VARCHAR(2000) DEFAULT NULL');
    }
}

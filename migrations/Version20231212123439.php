<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212123439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_data DROP description, DROP caracteristique, DROP homepicture, DROP info, CHANGE years years INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_data ADD description VARCHAR(2000) DEFAULT NULL, ADD caracteristique VARCHAR(2000) DEFAULT NULL, ADD homepicture VARCHAR(255) DEFAULT NULL, ADD info VARCHAR(2000) DEFAULT NULL, CHANGE years years VARCHAR(255) DEFAULT NULL');
    }
}

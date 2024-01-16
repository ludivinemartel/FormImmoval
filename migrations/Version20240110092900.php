<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110092900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negociateur ADD roles JSON NOT NULL, ADD telephone VARCHAR(255) NOT NULL, ADD agence VARCHAR(255) NOT NULL, DROP portable, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_18D76828E7927C74 ON negociateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_18D76828E7927C74 ON negociateur');
        $this->addSql('ALTER TABLE negociateur ADD portable VARCHAR(255) DEFAULT NULL, DROP roles, DROP telephone, DROP agence, CHANGE email email VARCHAR(255) NOT NULL');
    }
}

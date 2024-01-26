<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117085021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_form_template ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users_form_template ADD CONSTRAINT FK_2FBF92CA67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FBF92CA67B3B43D ON users_form_template (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_form_template DROP FOREIGN KEY FK_2FBF92CA67B3B43D');
        $this->addSql('DROP INDEX UNIQ_2FBF92CA67B3B43D ON users_form_template');
        $this->addSql('ALTER TABLE users_form_template DROP users_id');
    }
}

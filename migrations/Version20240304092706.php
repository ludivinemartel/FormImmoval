<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304092706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_submission_thank_message DROP FOREIGN KEY FK_C5FC2D7AF2B19FA9');
        $this->addSql('DROP TABLE form_submission_thank_message');
        $this->addSql('ALTER TABLE form_template ADD thank_you_message VARCHAR(2000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form_submission_thank_message (id INT AUTO_INCREMENT NOT NULL, form_template_id INT NOT NULL, message VARCHAR(2000) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_C5FC2D7AF2B19FA9 (form_template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE form_submission_thank_message ADD CONSTRAINT FK_C5FC2D7AF2B19FA9 FOREIGN KEY (form_template_id) REFERENCES form_template (id)');
        $this->addSql('ALTER TABLE form_template DROP thank_you_message');
    }
}

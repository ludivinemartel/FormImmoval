<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108125939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse ADD form_question_id INT NOT NULL');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCE94C66AE FOREIGN KEY (form_question_id) REFERENCES form_question (id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCE94C66AE ON form_reponse (form_question_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCE94C66AE');
        $this->addSql('DROP INDEX IDX_6EDABEFCE94C66AE ON form_reponse');
        $this->addSql('ALTER TABLE form_reponse DROP form_question_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109081036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCF2B19FA9');
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCE58C74A8');
        $this->addSql('ALTER TABLE form_reponse DROP FOREIGN KEY FK_6EDABEFCE94C66AE');
        $this->addSql('DROP INDEX IDX_6EDABEFCE58C74A8 ON form_reponse');
        $this->addSql('DROP INDEX IDX_6EDABEFCE94C66AE ON form_reponse');
        $this->addSql('DROP INDEX IDX_6EDABEFCF2B19FA9 ON form_reponse');
        $this->addSql('ALTER TABLE form_reponse DROP form_template_id, DROP negociateur_id, DROP form_question_id, DROP form_text_respons');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_reponse ADD form_template_id INT DEFAULT NULL, ADD negociateur_id INT DEFAULT NULL, ADD form_question_id INT DEFAULT NULL, ADD form_text_respons LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCF2B19FA9 FOREIGN KEY (form_template_id) REFERENCES form_template (id)');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCE58C74A8 FOREIGN KEY (negociateur_id) REFERENCES negociateur (id)');
        $this->addSql('ALTER TABLE form_reponse ADD CONSTRAINT FK_6EDABEFCE94C66AE FOREIGN KEY (form_question_id) REFERENCES form_question (id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCE58C74A8 ON form_reponse (negociateur_id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCE94C66AE ON form_reponse (form_question_id)');
        $this->addSql('CREATE INDEX IDX_6EDABEFCF2B19FA9 ON form_reponse (form_template_id)');
    }
}

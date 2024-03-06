<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305081703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_response ADD mandat_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD vente_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_6edabefc10e954b7 TO IDX_8F418EBF10E954B7');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_6edabefce94c66ae TO IDX_8F418EBFE94C66AE');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_6edabefca76ed395 TO IDX_8F418EBFA76ED395');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_response DROP mandat_date, DROP vente_date');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_8f418ebf10e954b7 TO IDX_6EDABEFC10E954B7');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_8f418ebfa76ed395 TO IDX_6EDABEFCA76ED395');
        $this->addSql('ALTER TABLE form_response RENAME INDEX idx_8f418ebfe94c66ae TO IDX_6EDABEFCE94C66AE');
    }
}

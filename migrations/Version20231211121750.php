<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231211121750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form_data (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(2000) DEFAULT NULL, name VARCHAR(255) NOT NULL, forname VARCHAR(255) NOT NULL, phone INT NOT NULL, mail VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, adresse VARCHAR(2000) NOT NULL, quartier VARCHAR(255) NOT NULL, caracteristique VARCHAR(2000) DEFAULT NULL, surface INT NOT NULL, sejour INT NOT NULL, pieces INT NOT NULL, chambres INT NOT NULL, bain INT DEFAULT NULL, eau INT DEFAULT NULL, etat VARCHAR(255) DEFAULT NULL, locataire VARCHAR(255) NOT NULL, homepicture VARCHAR(255) DEFAULT NULL, immeuble VARCHAR(2000) DEFAULT NULL, years INT DEFAULT NULL, stagehome INT DEFAULT NULL, stage INT DEFAULT NULL, chauffage VARCHAR(255) DEFAULT NULL, balcon INT DEFAULT NULL, terrasse INT DEFAULT NULL, cave VARCHAR(255) DEFAULT NULL, info VARCHAR(2000) DEFAULT NULL, parking INT DEFAULT NULL, garage INT DEFAULT NULL, view VARCHAR(255) DEFAULT NULL, exposition VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE form_data');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309144121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maison_reservation (id INT AUTO_INCREMENT NOT NULL, maisonshotes_id INT DEFAULT NULL, prix VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, createdat DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, start DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, end DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_3DDFB7C238B45370 (maisonshotes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maison_reservation ADD CONSTRAINT FK_3DDFB7C238B45370 FOREIGN KEY (maisonshotes_id) REFERENCES maisonshotes (id)');
        $this->addSql('DROP TABLE reservation_maison');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation_maison (id INT AUTO_INCREMENT NOT NULL, id_r INT NOT NULL, prix VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE maison_reservation');
        $this->addSql('ALTER TABLE maisonhoteimage CHANGE image_name image_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE maisonshotes CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE localisation localisation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE proprietaire proprietaire VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_maison CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

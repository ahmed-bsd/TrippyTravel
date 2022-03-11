<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311022519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maison_reservation (id INT AUTO_INCREMENT NOT NULL, maisonshotes_id INT DEFAULT NULL, prix VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, createdat DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, start DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, end DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_3DDFB7C238B45370 (maisonshotes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maisonhoteimage (id INT AUTO_INCREMENT NOT NULL, maisonshotes_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_3F087E038B45370 (maisonshotes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maisonshotes (id INT AUTO_INCREMENT NOT NULL, type_maison_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, capacite INT NOT NULL, localisation VARCHAR(255) NOT NULL, proprietaire VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, nbr_chambres INT NOT NULL, INDEX IDX_AF236C2A29A199BF (type_maison_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_maison (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, pub TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maison_reservation ADD CONSTRAINT FK_3DDFB7C238B45370 FOREIGN KEY (maisonshotes_id) REFERENCES maisonshotes (id)');
        $this->addSql('ALTER TABLE maisonhoteimage ADD CONSTRAINT FK_3F087E038B45370 FOREIGN KEY (maisonshotes_id) REFERENCES maisonshotes (id)');
        $this->addSql('ALTER TABLE maisonshotes ADD CONSTRAINT FK_AF236C2A29A199BF FOREIGN KEY (type_maison_id) REFERENCES type_maison (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maison_reservation DROP FOREIGN KEY FK_3DDFB7C238B45370');
        $this->addSql('ALTER TABLE maisonhoteimage DROP FOREIGN KEY FK_3F087E038B45370');
        $this->addSql('ALTER TABLE maisonshotes DROP FOREIGN KEY FK_AF236C2A29A199BF');
        $this->addSql('DROP TABLE maison_reservation');
        $this->addSql('DROP TABLE maisonhoteimage');
        $this->addSql('DROP TABLE maisonshotes');
        $this->addSql('DROP TABLE type_maison');
    }
}

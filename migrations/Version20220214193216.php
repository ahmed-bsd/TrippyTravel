<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214193216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maisonshotes ADD type_maison_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE maisonshotes ADD CONSTRAINT FK_AF236C2A29A199BF FOREIGN KEY (type_maison_id) REFERENCES type_maison (id)');
        $this->addSql('CREATE INDEX IDX_AF236C2A29A199BF ON maisonshotes (type_maison_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maisonshotes DROP FOREIGN KEY FK_AF236C2A29A199BF');
        $this->addSql('DROP INDEX IDX_AF236C2A29A199BF ON maisonshotes');
        $this->addSql('ALTER TABLE maisonshotes DROP type_maison_id, CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE localisation localisation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE proprietaire proprietaire VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type_maison CHANGE libelle libelle VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

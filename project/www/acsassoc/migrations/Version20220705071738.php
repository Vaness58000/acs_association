<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705071738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits ADD lieu_achat VARCHAR(255) NOT NULL, CHANGE achat_at achat_at DATETIME DEFAULT NULL, CHANGE guarantee_at guarantee_at DATETIME DEFAULT NULL, CHANGE manuel_src manuel_src VARCHAR(255) NOT NULL, CHANGE ticket_src ticket_src VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP lieu_achat, CHANGE achat_at achat_at DATETIME NOT NULL, CHANGE guarantee_at guarantee_at DATETIME NOT NULL, CHANGE manuel_src manuel_src VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE ticket_src ticket_src VARCHAR(255) DEFAULT \'\' NOT NULL');
    }
}

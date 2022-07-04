<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220701094524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE categories ADD color VARCHAR(7) NOT NULL');
        $this->addSql('ALTER TABLE produits CHANGE achat_at achat_at DATETIME DEFAULT NULL, CHANGE guarantee_at guarantee_at DATETIME DEFAULT NULL, CHANGE manuel_src manuel_src VARCHAR(255) NOT NULL, CHANGE ticket_src ticket_src VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, firstname VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE categories DROP color');
        $this->addSql('ALTER TABLE produits CHANGE achat_at achat_at DATETIME NOT NULL, CHANGE guarantee_at guarantee_at DATETIME NOT NULL, CHANGE manuel_src manuel_src VARCHAR(255) DEFAULT \'\' NOT NULL, CHANGE ticket_src ticket_src VARCHAR(255) DEFAULT \'\' NOT NULL');
    }
}

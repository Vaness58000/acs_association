<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220629080846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, produits_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, src VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6ACD11A2CF (produits_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6ACD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C7B478B1A');
        $this->addSql('DROP INDEX idx_be2ddf8c7b478b1a ON produits');
        $this->addSql('CREATE INDEX IDX_BE2DDF8CA21214B7 ON produits (categories_id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C7B478B1A FOREIGN KEY (categories_id) REFERENCES categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE images');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CA21214B7');
        $this->addSql('DROP INDEX idx_be2ddf8ca21214b7 ON produits');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C7B478B1A ON produits (categories_id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
    }
}

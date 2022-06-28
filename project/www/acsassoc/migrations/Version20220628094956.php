<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628094956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE add_files (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, src VARCHAR(255) NOT NULL, INDEX IDX_BB864A98C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE add_files ADD CONSTRAINT FK_BB864A98C54C8C93 FOREIGN KEY (type_id) REFERENCES add_files (id)');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C7B478B1A');
        $this->addSql('DROP INDEX IDX_BE2DDF8C7B478B1A ON produits');
        $this->addSql('ALTER TABLE produits CHANGE categories_id categories_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C7B478B1A ON produits (categories_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE add_files DROP FOREIGN KEY FK_BB864A98C54C8C93');
        $this->addSql('DROP TABLE add_files');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C7B478B1A');
        $this->addSql('DROP INDEX IDX_BE2DDF8C7B478B1A ON produits');
        $this->addSql('ALTER TABLE produits CHANGE categories_id_id categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C7B478B1A FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C7B478B1A ON produits (categories_id)');
    }
}

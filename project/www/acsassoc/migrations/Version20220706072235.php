<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706072235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE FULLTEXT INDEX IDX_3AF346685E237E06 ON categories (name)');
        $this->addSql('CREATE FULLTEXT INDEX IDX_BE2DDF8C5E237E06FEC530A9 ON produits (name, content)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_3AF346685E237E06 ON categories');
        $this->addSql('DROP INDEX IDX_BE2DDF8C5E237E06FEC530A9 ON produits');
    }
}

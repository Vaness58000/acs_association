<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628115219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE add_files_produits (add_files_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_C23698919B0CAD59 (add_files_id), INDEX IDX_C2369891CD11A2CF (produits_id), PRIMARY KEY(add_files_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, src VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_produits (images_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_1D0EA2E6D44F05E5 (images_id), INDEX IDX_1D0EA2E6CD11A2CF (produits_id), PRIMARY KEY(images_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE add_files_produits ADD CONSTRAINT FK_C23698919B0CAD59 FOREIGN KEY (add_files_id) REFERENCES add_files (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE add_files_produits ADD CONSTRAINT FK_C2369891CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_produits ADD CONSTRAINT FK_1D0EA2E6D44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images_produits ADD CONSTRAINT FK_1D0EA2E6CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE add_files DROP FOREIGN KEY FK_BB864A98C54C8C93');
        $this->addSql('DROP INDEX IDX_BB864A98C54C8C93 ON add_files');
        $this->addSql('ALTER TABLE add_files ADD type_file_id INT DEFAULT NULL, DROP type_id');
        $this->addSql('ALTER TABLE add_files ADD CONSTRAINT FK_BB864A98BBEA1699 FOREIGN KEY (type_file_id) REFERENCES type_file (id)');
        $this->addSql('CREATE INDEX IDX_BB864A98BBEA1699 ON add_files (type_file_id)');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C7B478B1A');
        $this->addSql('DROP INDEX IDX_BE2DDF8C7B478B1A ON produits');
        $this->addSql('ALTER TABLE produits CHANGE categories_id_id categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8CA21214B7 ON produits (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images_produits DROP FOREIGN KEY FK_1D0EA2E6D44F05E5');
        $this->addSql('DROP TABLE add_files_produits');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE images_produits');
        $this->addSql('ALTER TABLE add_files DROP FOREIGN KEY FK_BB864A98BBEA1699');
        $this->addSql('DROP INDEX IDX_BB864A98BBEA1699 ON add_files');
        $this->addSql('ALTER TABLE add_files ADD type_id INT NOT NULL, DROP type_file_id');
        $this->addSql('ALTER TABLE add_files ADD CONSTRAINT FK_BB864A98C54C8C93 FOREIGN KEY (type_id) REFERENCES add_files (id)');
        $this->addSql('CREATE INDEX IDX_BB864A98C54C8C93 ON add_files (type_id)');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CA21214B7');
        $this->addSql('DROP INDEX IDX_BE2DDF8CA21214B7 ON produits');
        $this->addSql('ALTER TABLE produits CHANGE categories_id categories_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C7B478B1A ON produits (categories_id_id)');
    }
}

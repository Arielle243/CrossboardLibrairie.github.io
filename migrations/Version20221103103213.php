<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103103213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_rayon (product_id INT NOT NULL, rayon_id INT NOT NULL, INDEX IDX_74B9C7604584665A (product_id), INDEX IDX_74B9C760D3202E52 (rayon_id), PRIMARY KEY(product_id, rayon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_rayon ADD CONSTRAINT FK_74B9C7604584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_rayon ADD CONSTRAINT FK_74B9C760D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_rayon DROP FOREIGN KEY FK_74B9C7604584665A');
        $this->addSql('ALTER TABLE product_rayon DROP FOREIGN KEY FK_74B9C760D3202E52');
        $this->addSql('DROP TABLE product_rayon');
    }
}

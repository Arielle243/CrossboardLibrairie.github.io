<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021182708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE souscategory_category DROP FOREIGN KEY FK_5C3FB43012469DE2');
        $this->addSql('ALTER TABLE souscategory_category DROP FOREIGN KEY FK_5C3FB43097753870');
        $this->addSql('DROP TABLE souscategory_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE souscategory_category (souscategory_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5C3FB43097753870 (souscategory_id), INDEX IDX_5C3FB43012469DE2 (category_id), PRIMARY KEY(souscategory_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE souscategory_category ADD CONSTRAINT FK_5C3FB43012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souscategory_category ADD CONSTRAINT FK_5C3FB43097753870 FOREIGN KEY (souscategory_id) REFERENCES souscategory (id) ON DELETE CASCADE');
    }
}

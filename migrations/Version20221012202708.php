<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012202708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE souscategory (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategory_product (souscategory_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_A538EE5397753870 (souscategory_id), INDEX IDX_A538EE534584665A (product_id), PRIMARY KEY(souscategory_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategory_category (souscategory_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_5C3FB43097753870 (souscategory_id), INDEX IDX_5C3FB43012469DE2 (category_id), PRIMARY KEY(souscategory_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE souscategory_product ADD CONSTRAINT FK_A538EE5397753870 FOREIGN KEY (souscategory_id) REFERENCES souscategory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souscategory_product ADD CONSTRAINT FK_A538EE534584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souscategory_category ADD CONSTRAINT FK_5C3FB43097753870 FOREIGN KEY (souscategory_id) REFERENCES souscategory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souscategory_category ADD CONSTRAINT FK_5C3FB43012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_categories_product DROP FOREIGN KEY FK_D85897674584665A');
        $this->addSql('ALTER TABLE sous_categories_product DROP FOREIGN KEY FK_D85897679F751138');
        $this->addSql('DROP TABLE sous_categories');
        $this->addSql('DROP TABLE sous_categories_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sous_categories (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, statut TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sous_categories_product (sous_categories_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_D85897679F751138 (sous_categories_id), INDEX IDX_D85897674584665A (product_id), PRIMARY KEY(sous_categories_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sous_categories_product ADD CONSTRAINT FK_D85897674584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sous_categories_product ADD CONSTRAINT FK_D85897679F751138 FOREIGN KEY (sous_categories_id) REFERENCES sous_categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE souscategory_product DROP FOREIGN KEY FK_A538EE5397753870');
        $this->addSql('ALTER TABLE souscategory_product DROP FOREIGN KEY FK_A538EE534584665A');
        $this->addSql('ALTER TABLE souscategory_category DROP FOREIGN KEY FK_5C3FB43097753870');
        $this->addSql('ALTER TABLE souscategory_category DROP FOREIGN KEY FK_5C3FB43012469DE2');
        $this->addSql('DROP TABLE souscategory');
        $this->addSql('DROP TABLE souscategory_product');
        $this->addSql('DROP TABLE souscategory_category');
    }
}

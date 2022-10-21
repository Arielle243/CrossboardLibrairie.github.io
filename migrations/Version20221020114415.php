<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221020114415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_souscategory (product_id INT NOT NULL, souscategory_id INT NOT NULL, INDEX IDX_DCA9A29A4584665A (product_id), INDEX IDX_DCA9A29A97753870 (souscategory_id), PRIMARY KEY(product_id, souscategory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_souscategory ADD CONSTRAINT FK_DCA9A29A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_souscategory ADD CONSTRAINT FK_DCA9A29A97753870 FOREIGN KEY (souscategory_id) REFERENCES souscategory (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_souscategory DROP FOREIGN KEY FK_DCA9A29A4584665A');
        $this->addSql('ALTER TABLE product_souscategory DROP FOREIGN KEY FK_DCA9A29A97753870');
        $this->addSql('DROP TABLE product_souscategory');
    }
}

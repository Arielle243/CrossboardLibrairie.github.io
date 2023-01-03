<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124150001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E338989DF4 FOREIGN KEY (ligne_panier_id) REFERENCES ligne_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E338989DF4');
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E34584665A');
    }
}

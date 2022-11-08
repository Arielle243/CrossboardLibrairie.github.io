<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104000300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_panier (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, quantite INT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_21691B4F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier_product (ligne_panier_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_134EF2E338989DF4 (ligne_panier_id), INDEX IDX_134EF2E34584665A (product_id), PRIMARY KEY(ligne_panier_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier_commande (ligne_panier_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_FF4ECE1C38989DF4 (ligne_panier_id), INDEX IDX_FF4ECE1C82EA2E54 (commande_id), PRIMARY KEY(ligne_panier_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, number_product INT NOT NULL, montant_total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B4F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E338989DF4 FOREIGN KEY (ligne_panier_id) REFERENCES ligne_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_commande ADD CONSTRAINT FK_FF4ECE1C38989DF4 FOREIGN KEY (ligne_panier_id) REFERENCES ligne_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_commande ADD CONSTRAINT FK_FF4ECE1C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B4F77D927C');
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E338989DF4');
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E34584665A');
        $this->addSql('ALTER TABLE ligne_panier_commande DROP FOREIGN KEY FK_FF4ECE1C38989DF4');
        $this->addSql('ALTER TABLE ligne_panier_commande DROP FOREIGN KEY FK_FF4ECE1C82EA2E54');
        $this->addSql('DROP TABLE ligne_panier');
        $this->addSql('DROP TABLE ligne_panier_product');
        $this->addSql('DROP TABLE ligne_panier_commande');
        $this->addSql('DROP TABLE panier');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221031084231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE lignecommande ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B79394584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_853B79394584665A ON lignecommande (product_id)');
        $this->addSql('ALTER TABLE user CHANGE statut statut TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP updated_at');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B79394584665A');
        $this->addSql('DROP INDEX IDX_853B79394584665A ON lignecommande');
        $this->addSql('ALTER TABLE lignecommande DROP product_id');
        $this->addSql('ALTER TABLE user CHANGE statut statut TINYINT(1) DEFAULT NULL');
    }
}

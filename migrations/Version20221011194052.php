<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221011194052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rayons (id INT AUTO_INCREMENT NOT NULL, litterature VARCHAR(255) NOT NULL, jeunesse VARCHAR(255) NOT NULL, loisirs VARCHAR(255) NOT NULL, nature VARCHAR(255) NOT NULL, voyages VARCHAR(255) NOT NULL, bandes_dessinees VARCHAR(255) NOT NULL, humour VARCHAR(255) NOT NULL, arts VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, sciences_humaines VARCHAR(255) NOT NULL, scolaires VARCHAR(255) NOT NULL, pedagogie VARCHAR(255) NOT NULL, medecine VARCHAR(255) NOT NULL, sciences VARCHAR(255) NOT NULL, techniques VARCHAR(255) NOT NULL, entreprise VARCHAR(255) NOT NULL, emploi VARCHAR(255) NOT NULL, droits VARCHAR(255) NOT NULL, economies VARCHAR(255) NOT NULL, langues VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rayons');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

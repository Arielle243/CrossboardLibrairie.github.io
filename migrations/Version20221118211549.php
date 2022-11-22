<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118211549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresses (id INT AUTO_INCREMENT NOT NULL, commandes_id INT NOT NULL, name VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6FCA75168BF5C2E6 (commandes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE addresses_user (addresses_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1DAAF0205713BC80 (addresses_id), INDEX IDX_1DAAF020A76ED395 (user_id), PRIMARY KEY(addresses_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, commandes_id INT NOT NULL, mode_livraison VARCHAR(255) NOT NULL, statut_livraison TINYINT(1) NOT NULL, INDEX IDX_A60C9F1F8BF5C2E6 (commandes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75168BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE addresses_user ADD CONSTRAINT FK_1DAAF0205713BC80 FOREIGN KEY (addresses_id) REFERENCES addresses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addresses_user ADD CONSTRAINT FK_1DAAF020A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F8BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75168BF5C2E6');
        $this->addSql('ALTER TABLE addresses_user DROP FOREIGN KEY FK_1DAAF0205713BC80');
        $this->addSql('ALTER TABLE addresses_user DROP FOREIGN KEY FK_1DAAF020A76ED395');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F8BF5C2E6');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE addresses_user');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE transporteur');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124145739 extends AbstractMigration
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
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, illustration VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_commande DATETIME NOT NULL, statut_commande VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, users_id INT DEFAULT NULL, commentparent_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, rating INT DEFAULT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_9474526C4584665A (product_id), INDEX IDX_9474526C67B3B43D (users_id), INDEX IDX_9474526C41FEEC16 (commentparent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, quantite INT NOT NULL, statut TINYINT(1) NOT NULL, INDEX IDX_21691B4F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier_product (ligne_panier_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_134EF2E338989DF4 (ligne_panier_id), INDEX IDX_134EF2E34584665A (product_id), PRIMARY KEY(ligne_panier_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ligne_panier_commande (ligne_panier_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_FF4ECE1C38989DF4 (ligne_panier_id), INDEX IDX_FF4ECE1C82EA2E54 (commande_id), PRIMARY KEY(ligne_panier_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignecommande (id INT AUTO_INCREMENT NOT NULL, commandes_id INT NOT NULL, product_id INT NOT NULL, quantite INT DEFAULT NULL, INDEX IDX_853B79398BF5C2E6 (commandes_id), INDEX IDX_853B79394584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison (id INT AUTO_INCREMENT NOT NULL, commandes_id INT NOT NULL, mode_livraison VARCHAR(255) NOT NULL, statut_livraison TINYINT(1) NOT NULL, date_livraison DATE NOT NULL, INDEX IDX_A60C9F1F8BF5C2E6 (commandes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alt_text VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, number_product INT NOT NULL, montant_total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, users_id INT NOT NULL, featured_image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, excerpt LONGTEXT NOT NULL, description LONGTEXT DEFAULT NULL, author VARCHAR(255) NOT NULL, published_at DATE DEFAULT NULL, editor VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, format VARCHAR(255) NOT NULL, stock INT DEFAULT NULL, langues VARCHAR(255) DEFAULT NULL, isbn VARCHAR(255) NOT NULL, age VARCHAR(255) DEFAULT NULL, updated_at DATE DEFAULT NULL, created_at DATE DEFAULT NULL, statut TINYINT(1) NOT NULL, best_seller TINYINT(1) DEFAULT NULL, nouveaute TINYINT(1) DEFAULT NULL, nb_product INT DEFAULT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD67B3B43D (users_id), INDEX IDX_D34A04AD3569D950 (featured_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_souscategory (product_id INT NOT NULL, souscategory_id INT NOT NULL, INDEX IDX_DCA9A29A4584665A (product_id), INDEX IDX_DCA9A29A97753870 (souscategory_id), PRIMARY KEY(product_id, souscategory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_rayon (product_id INT NOT NULL, rayon_id INT NOT NULL, INDEX IDX_74B9C7604584665A (product_id), INDEX IDX_74B9C760D3202E52 (rayon_id), PRIMARY KEY(product_id, rayon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATE DEFAULT NULL, updated_at DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategory (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, statut TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporteur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, address VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, city VARCHAR(255) NOT NULL, address_delivery VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, statut TINYINT(1) NOT NULL, date_registration DATETIME DEFAULT NULL, birthdate DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE addresses ADD CONSTRAINT FK_6FCA75168BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE addresses_user ADD CONSTRAINT FK_1DAAF0205713BC80 FOREIGN KEY (addresses_id) REFERENCES addresses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE addresses_user ADD CONSTRAINT FK_1DAAF020A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41FEEC16 FOREIGN KEY (commentparent_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE ligne_panier ADD CONSTRAINT FK_21691B4F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E338989DF4 FOREIGN KEY (ligne_panier_id) REFERENCES ligne_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_product ADD CONSTRAINT FK_134EF2E34584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_commande ADD CONSTRAINT FK_FF4ECE1C38989DF4 FOREIGN KEY (ligne_panier_id) REFERENCES ligne_panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ligne_panier_commande ADD CONSTRAINT FK_FF4ECE1C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B79398BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B79394584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1F8BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD3569D950 FOREIGN KEY (featured_image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE product_souscategory ADD CONSTRAINT FK_DCA9A29A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_souscategory ADD CONSTRAINT FK_DCA9A29A97753870 FOREIGN KEY (souscategory_id) REFERENCES souscategory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_rayon ADD CONSTRAINT FK_74B9C7604584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_rayon ADD CONSTRAINT FK_74B9C760D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE addresses DROP FOREIGN KEY FK_6FCA75168BF5C2E6');
        $this->addSql('ALTER TABLE addresses_user DROP FOREIGN KEY FK_1DAAF0205713BC80');
        $this->addSql('ALTER TABLE addresses_user DROP FOREIGN KEY FK_1DAAF020A76ED395');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4584665A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C67B3B43D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C41FEEC16');
        $this->addSql('ALTER TABLE ligne_panier DROP FOREIGN KEY FK_21691B4F77D927C');
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E338989DF4');
        $this->addSql('ALTER TABLE ligne_panier_product DROP FOREIGN KEY FK_134EF2E34584665A');
        $this->addSql('ALTER TABLE ligne_panier_commande DROP FOREIGN KEY FK_FF4ECE1C38989DF4');
        $this->addSql('ALTER TABLE ligne_panier_commande DROP FOREIGN KEY FK_FF4ECE1C82EA2E54');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B79398BF5C2E6');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B79394584665A');
        $this->addSql('ALTER TABLE livraison DROP FOREIGN KEY FK_A60C9F1F8BF5C2E6');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD67B3B43D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3569D950');
        $this->addSql('ALTER TABLE product_souscategory DROP FOREIGN KEY FK_DCA9A29A4584665A');
        $this->addSql('ALTER TABLE product_souscategory DROP FOREIGN KEY FK_DCA9A29A97753870');
        $this->addSql('ALTER TABLE product_rayon DROP FOREIGN KEY FK_74B9C7604584665A');
        $this->addSql('ALTER TABLE product_rayon DROP FOREIGN KEY FK_74B9C760D3202E52');
        $this->addSql('DROP TABLE addresses');
        $this->addSql('DROP TABLE addresses_user');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE ligne_panier');
        $this->addSql('DROP TABLE ligne_panier_product');
        $this->addSql('DROP TABLE ligne_panier_commande');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_souscategory');
        $this->addSql('DROP TABLE product_rayon');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('DROP TABLE souscategory');
        $this->addSql('DROP TABLE transporteur');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213161911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP published_at, DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD birth_date DATE NOT NULL, DROP date_registration, DROP birthdate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD published_at DATE DEFAULT NULL, ADD updated_at DATE DEFAULT NULL, ADD created_at DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD date_registration DATETIME DEFAULT NULL, ADD birthdate DATE DEFAULT NULL, DROP created_at, DROP updated_at, DROP birth_date');
    }
}

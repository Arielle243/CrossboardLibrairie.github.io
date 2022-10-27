<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221026083718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD commentparent_id INT DEFAULT NULL, ADD statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C41FEEC16 FOREIGN KEY (commentparent_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_9474526C41FEEC16 ON comment (commentparent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C41FEEC16');
        $this->addSql('DROP INDEX IDX_9474526C41FEEC16 ON comment');
        $this->addSql('ALTER TABLE comment DROP commentparent_id, DROP statut');
    }
}

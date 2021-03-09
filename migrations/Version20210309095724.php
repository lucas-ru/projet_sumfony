<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309095724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD COLUMN title VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, content, author, create_at, is_published, is_deleted FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, is_published BOOLEAN NOT NULL, is_deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO post (id, content, author, create_at, is_published, is_deleted) SELECT id, content, author, create_at, is_published, is_deleted FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}

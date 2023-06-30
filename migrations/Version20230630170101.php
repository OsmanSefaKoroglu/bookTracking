<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630170101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE books_user (books_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(books_id, user_id))');
        $this->addSql('CREATE INDEX IDX_AE1A76667DD8AC20 ON books_user (books_id)');
        $this->addSql('CREATE INDEX IDX_AE1A7666A76ED395 ON books_user (user_id)');
        $this->addSql('ALTER TABLE books_user ADD CONSTRAINT FK_AE1A76667DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books_user ADD CONSTRAINT FK_AE1A7666A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A9267B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4A1B2A9267B3B43D ON books (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE books_user DROP CONSTRAINT FK_AE1A76667DD8AC20');
        $this->addSql('ALTER TABLE books_user DROP CONSTRAINT FK_AE1A7666A76ED395');
        $this->addSql('DROP TABLE books_user');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A9267B3B43D');
        $this->addSql('DROP INDEX IDX_4A1B2A9267B3B43D');
        $this->addSql('ALTER TABLE books DROP users_id');
    }
}

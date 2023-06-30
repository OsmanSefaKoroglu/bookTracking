<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630144137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_be_read_user (to_be_read_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(to_be_read_id, user_id))');
        $this->addSql('CREATE INDEX IDX_ECDB6E45218106A7 ON to_be_read_user (to_be_read_id)');
        $this->addSql('CREATE INDEX IDX_ECDB6E45A76ED395 ON to_be_read_user (user_id)');
        $this->addSql('ALTER TABLE to_be_read_user ADD CONSTRAINT FK_ECDB6E45218106A7 FOREIGN KEY (to_be_read_id) REFERENCES to_be_read (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE to_be_read_user ADD CONSTRAINT FK_ECDB6E45A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE to_be_read_user DROP CONSTRAINT FK_ECDB6E45218106A7');
        $this->addSql('ALTER TABLE to_be_read_user DROP CONSTRAINT FK_ECDB6E45A76ED395');
        $this->addSql('DROP TABLE to_be_read_user');
    }
}

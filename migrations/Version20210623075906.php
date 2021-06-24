<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623075906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE blog_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE blog_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE blog_comment (id INT NOT NULL, blog_post_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7882EFEFA77FBEAF ON blog_comment (blog_post_id)');
        $this->addSql('CREATE TABLE blog_post (id INT NOT NULL, title VARCHAR(255) NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE blog_comment ADD CONSTRAINT FK_7882EFEFA77FBEAF FOREIGN KEY (blog_post_id) REFERENCES blog_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE blog_comment DROP CONSTRAINT FK_7882EFEFA77FBEAF');
        $this->addSql('DROP SEQUENCE blog_comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE blog_post_id_seq CASCADE');
        $this->addSql('DROP TABLE blog_comment');
        $this->addSql('DROP TABLE blog_post');
    }
}

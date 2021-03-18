<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318094412 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime ADD kinopoisk_id VARCHAR(16) NOT NULL, ADD imdb_id VARCHAR(16) NOT NULL, ADD mdl_id VARCHAR(16) NOT NULL, ADD shikimori_id VARCHAR(16) NOT NULL, ADD worldartanime_id VARCHAR(16) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE anime DROP kinopoisk_id, DROP imdb_id, DROP mdl_id, DROP shikimori_id, DROP worldartanime_id');
    }
}

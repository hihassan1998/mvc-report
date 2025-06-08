<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608153332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__emissions_data AS SELECT id, year, emissions_sweden, emissions_aborad, total FROM emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE emissions_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, emissions_sweden DOUBLE PRECISION DEFAULT NULL, emissions_abroad DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO emissions_data (id, year, emissions_sweden, emissions_abroad, total) SELECT id, year, emissions_sweden, emissions_aborad, total FROM __temp__emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__emissions_data
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__emissions_data AS SELECT id, year, emissions_sweden, total, emissions_abroad FROM emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE emissions_data (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, year INTEGER NOT NULL, emissions_sweden DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, emissions_aborad DOUBLE PRECISION DEFAULT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO emissions_data (id, year, emissions_sweden, total, emissions_aborad) SELECT id, year, emissions_sweden, total, emissions_abroad FROM __temp__emissions_data
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__emissions_data
        SQL);
    }
}

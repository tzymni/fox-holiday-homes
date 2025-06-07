<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607191226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE houses (id VARCHAR(36) NOT NULL, created_by INT DEFAULT NULL, name VARCHAR(255) NOT NULL, max_guests INT NOT NULL, area_in_square_meters DOUBLE PRECISION NOT NULL, created_at_utc TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at_utc TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_95D7F5CBDE12AB56 ON houses (created_by)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN houses.created_at_utc IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN houses.updated_at_utc IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE houses ADD CONSTRAINT FK_95D7F5CBDE12AB56 FOREIGN KEY (created_by) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE houses DROP CONSTRAINT FK_95D7F5CBDE12AB56
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE houses
        SQL);
    }
}

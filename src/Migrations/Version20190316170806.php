<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190316170806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_category ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_40A0F0115E237E06 ON event_category (name)');
        $this->addSql('ALTER TABLE event_collaborator ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX fullname_idx ON event_collaborator (name, surname)');
        $this->addSql('ALTER TABLE event_location ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1872601B741D53CD ON event_location (place)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_40A0F0115E237E06 ON event_category');
        $this->addSql('ALTER TABLE event_category DROP slug');
        $this->addSql('DROP INDEX fullname_idx ON event_collaborator');
        $this->addSql('ALTER TABLE event_collaborator DROP slug');
        $this->addSql('DROP INDEX UNIQ_1872601B741D53CD ON event_location');
        $this->addSql('ALTER TABLE event_location DROP slug');
    }
}

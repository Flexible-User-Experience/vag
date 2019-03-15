<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315190450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, priority SMALLINT NOT NULL, is_available TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_collaborator (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_activity (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, begin DATE NOT NULL, end DATE NOT NULL, short_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_available TINYINT(1) NOT NULL, INDEX IDX_EA98E08A12469DE2 (category_id), INDEX IDX_EA98E08A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_activity_event_collaborator (event_activity_id INT NOT NULL, event_collaborator_id INT NOT NULL, INDEX IDX_59DE2FE02A49B316 (event_activity_id), INDEX IDX_59DE2FE0F9DAE8BC (event_collaborator_id), PRIMARY KEY(event_activity_id, event_collaborator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_location (id INT AUTO_INCREMENT NOT NULL, place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_activity ADD CONSTRAINT FK_EA98E08A12469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('ALTER TABLE event_activity ADD CONSTRAINT FK_EA98E08A64D218E FOREIGN KEY (location_id) REFERENCES event_location (id)');
        $this->addSql('ALTER TABLE event_activity_event_collaborator ADD CONSTRAINT FK_59DE2FE02A49B316 FOREIGN KEY (event_activity_id) REFERENCES event_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_activity_event_collaborator ADD CONSTRAINT FK_59DE2FE0F9DAE8BC FOREIGN KEY (event_collaborator_id) REFERENCES event_collaborator (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_activity DROP FOREIGN KEY FK_EA98E08A12469DE2');
        $this->addSql('ALTER TABLE event_activity_event_collaborator DROP FOREIGN KEY FK_59DE2FE0F9DAE8BC');
        $this->addSql('ALTER TABLE event_activity_event_collaborator DROP FOREIGN KEY FK_59DE2FE02A49B316');
        $this->addSql('ALTER TABLE event_activity DROP FOREIGN KEY FK_EA98E08A64D218E');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE event_collaborator');
        $this->addSql('DROP TABLE event_activity');
        $this->addSql('DROP TABLE event_activity_event_collaborator');
        $this->addSql('DROP TABLE event_location');
    }
}

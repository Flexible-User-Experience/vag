<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190420193921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_ticket (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, code VARCHAR(255) NOT NULL, purchase_date DATETIME DEFAULT NULL, checkin_date DATETIME DEFAULT NULL, is_available TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_A539DAF181C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_ticket ADD CONSTRAINT FK_A539DAF181C06096 FOREIGN KEY (activity_id) REFERENCES event_activity (id)');
        $this->addSql('ALTER TABLE event_activity ADD is_translated TINYINT(1) DEFAULT \'0\', ADD tickets_amount INT DEFAULT NULL, ADD tickets_sold INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_ticket');
        $this->addSql('ALTER TABLE event_activity DROP is_translated, DROP tickets_amount, DROP tickets_sold');
    }
}

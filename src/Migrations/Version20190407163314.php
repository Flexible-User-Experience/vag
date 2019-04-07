<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190407163314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_message (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, subject VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, message TEXT NOT NULL, answer TEXT DEFAULT NULL, answered DATETIME DEFAULT NULL, legal_terms_has_been_accepted TINYINT(1) DEFAULT \'0\', has_been_readed TINYINT(1) DEFAULT \'0\', has_been_answered TINYINT(1) DEFAULT \'0\', created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_activity (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, location_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, begin DATETIME NOT NULL, end DATETIME NOT NULL, short_description VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, is_available TINYINT(1) DEFAULT \'1\', show_in_homepage TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_EA98E08A5E237E06 (name), INDEX IDX_EA98E08A12469DE2 (category_id), INDEX IDX_EA98E08A64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_activity_event_collaborator (event_activity_id INT NOT NULL, event_collaborator_id INT NOT NULL, INDEX IDX_59DE2FE02A49B316 (event_activity_id), INDEX IDX_59DE2FE0F9DAE8BC (event_collaborator_id), PRIMARY KEY(event_activity_id, event_collaborator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, priority SMALLINT NOT NULL, is_available TINYINT(1) DEFAULT \'1\', color VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_40A0F0115E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_collaborator (id INT AUTO_INCREMENT NOT NULL, gender SMALLINT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, short_description VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, show_in_homepage TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX fullname_idx (name, surname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_location (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, place VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX UNIQ_1872601B741D53CD (place), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_member (id INT AUTO_INCREMENT NOT NULL, gender SMALLINT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, job VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, show_in_frontend TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, UNIQUE INDEX team_fullname_idx (name, surname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, show_in_frontend TINYINT(1) DEFAULT \'1\', created DATETIME NOT NULL, updated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_activity_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_3A7510DF232D562B (object_id), UNIQUE INDEX event_activity_lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_category_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_836038B8232D562B (object_id), UNIQUE INDEX event_category_lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_collaborator_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_939F51D232D562B (object_id), UNIQUE INDEX event_collaborator_lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_location_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_222E9D97232D562B (object_id), UNIQUE INDEX event_location_lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_member_translation (id INT AUTO_INCREMENT NOT NULL, object_id INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_FC592FC232D562B (object_id), UNIQUE INDEX team_member_lookup_unique_idx (locale, object_id, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_activity ADD CONSTRAINT FK_EA98E08A12469DE2 FOREIGN KEY (category_id) REFERENCES event_category (id)');
        $this->addSql('ALTER TABLE event_activity ADD CONSTRAINT FK_EA98E08A64D218E FOREIGN KEY (location_id) REFERENCES event_location (id)');
        $this->addSql('ALTER TABLE event_activity_event_collaborator ADD CONSTRAINT FK_59DE2FE02A49B316 FOREIGN KEY (event_activity_id) REFERENCES event_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_activity_event_collaborator ADD CONSTRAINT FK_59DE2FE0F9DAE8BC FOREIGN KEY (event_collaborator_id) REFERENCES event_collaborator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_activity_translation ADD CONSTRAINT FK_3A7510DF232D562B FOREIGN KEY (object_id) REFERENCES event_activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_category_translation ADD CONSTRAINT FK_836038B8232D562B FOREIGN KEY (object_id) REFERENCES event_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_collaborator_translation ADD CONSTRAINT FK_939F51D232D562B FOREIGN KEY (object_id) REFERENCES event_collaborator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_location_translation ADD CONSTRAINT FK_222E9D97232D562B FOREIGN KEY (object_id) REFERENCES event_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_member_translation ADD CONSTRAINT FK_FC592FC232D562B FOREIGN KEY (object_id) REFERENCES team_member (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_activity_event_collaborator DROP FOREIGN KEY FK_59DE2FE02A49B316');
        $this->addSql('ALTER TABLE event_activity_translation DROP FOREIGN KEY FK_3A7510DF232D562B');
        $this->addSql('ALTER TABLE event_activity DROP FOREIGN KEY FK_EA98E08A12469DE2');
        $this->addSql('ALTER TABLE event_category_translation DROP FOREIGN KEY FK_836038B8232D562B');
        $this->addSql('ALTER TABLE event_activity_event_collaborator DROP FOREIGN KEY FK_59DE2FE0F9DAE8BC');
        $this->addSql('ALTER TABLE event_collaborator_translation DROP FOREIGN KEY FK_939F51D232D562B');
        $this->addSql('ALTER TABLE event_activity DROP FOREIGN KEY FK_EA98E08A64D218E');
        $this->addSql('ALTER TABLE event_location_translation DROP FOREIGN KEY FK_222E9D97232D562B');
        $this->addSql('ALTER TABLE team_member_translation DROP FOREIGN KEY FK_FC592FC232D562B');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE event_activity');
        $this->addSql('DROP TABLE event_activity_event_collaborator');
        $this->addSql('DROP TABLE event_category');
        $this->addSql('DROP TABLE event_collaborator');
        $this->addSql('DROP TABLE event_location');
        $this->addSql('DROP TABLE team_member');
        $this->addSql('DROP TABLE team_partner');
        $this->addSql('DROP TABLE event_activity_translation');
        $this->addSql('DROP TABLE event_category_translation');
        $this->addSql('DROP TABLE event_collaborator_translation');
        $this->addSql('DROP TABLE event_location_translation');
        $this->addSql('DROP TABLE team_member_translation');
        $this->addSql('DROP TABLE user');
    }
}

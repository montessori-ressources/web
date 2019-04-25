<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190421205438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE fos_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:array)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('DROP INDEX IDX_6697CC183DA5256D');
        $this->addSql('DROP INDEX IDX_6697CC1892DAD536');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classified_card_image AS SELECT classified_card_id, image_id FROM classified_card_image');
        $this->addSql('DROP TABLE classified_card_image');
        $this->addSql('CREATE TABLE classified_card_image (classified_card_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(classified_card_id, image_id), CONSTRAINT FK_6697CC1892DAD536 FOREIGN KEY (classified_card_id) REFERENCES classified_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6697CC183DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classified_card_image (classified_card_id, image_id) SELECT classified_card_id, image_id FROM __temp__classified_card_image');
        $this->addSql('DROP TABLE __temp__classified_card_image');
        $this->addSql('CREATE INDEX IDX_6697CC183DA5256D ON classified_card_image (image_id)');
        $this->addSql('CREATE INDEX IDX_6697CC1892DAD536 ON classified_card_image (classified_card_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP INDEX IDX_6697CC1892DAD536');
        $this->addSql('DROP INDEX IDX_6697CC183DA5256D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classified_card_image AS SELECT classified_card_id, image_id FROM classified_card_image');
        $this->addSql('DROP TABLE classified_card_image');
        $this->addSql('CREATE TABLE classified_card_image (classified_card_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(classified_card_id, image_id))');
        $this->addSql('INSERT INTO classified_card_image (classified_card_id, image_id) SELECT classified_card_id, image_id FROM __temp__classified_card_image');
        $this->addSql('DROP TABLE __temp__classified_card_image');
        $this->addSql('CREATE INDEX IDX_6697CC1892DAD536 ON classified_card_image (classified_card_id)');
        $this->addSql('CREATE INDEX IDX_6697CC183DA5256D ON classified_card_image (image_id)');
    }
}

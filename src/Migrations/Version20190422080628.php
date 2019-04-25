<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190422080628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE nomenclature (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('DROP INDEX IDX_6697CC1892DAD536');
        $this->addSql('DROP INDEX IDX_6697CC183DA5256D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__classified_card_image AS SELECT classified_card_id, image_id FROM classified_card_image');
        $this->addSql('DROP TABLE classified_card_image');
        $this->addSql('CREATE TABLE classified_card_image (classified_card_id INTEGER NOT NULL, image_id INTEGER NOT NULL, PRIMARY KEY(classified_card_id, image_id), CONSTRAINT FK_6697CC1892DAD536 FOREIGN KEY (classified_card_id) REFERENCES classified_card (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6697CC183DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO classified_card_image (classified_card_id, image_id) SELECT classified_card_id, image_id FROM __temp__classified_card_image');
        $this->addSql('DROP TABLE __temp__classified_card_image');
        $this->addSql('CREATE INDEX IDX_6697CC1892DAD536 ON classified_card_image (classified_card_id)');
        $this->addSql('CREATE INDEX IDX_6697CC183DA5256D ON classified_card_image (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE nomenclature');
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

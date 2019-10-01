<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190711021840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_799A3652C54C8C93');
        $this->addSql('DROP INDEX IDX_799A365277E5854A');
        $this->addSql('DROP INDEX IDX_799A365282F1BAF4');
        $this->addSql('DROP INDEX IDX_799A3652B03A8386');
        $this->addSql('CREATE TEMPORARY TABLE __temp__nomenclature AS SELECT id, created_by_id, language_id, mode_id, type_id, created_at, name FROM nomenclature');
        $this->addSql('DROP TABLE nomenclature');
        $this->addSql('CREATE TABLE nomenclature (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER NOT NULL, language_id INTEGER NOT NULL, mode_id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, status INTEGER NOT NULL, CONSTRAINT FK_799A3652B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_799A365282F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_799A365277E5854A FOREIGN KEY (mode_id) REFERENCES mode (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_799A3652C54C8C93 FOREIGN KEY (type_id) REFERENCES illustration_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO nomenclature (id, created_by_id, language_id, mode_id, type_id, created_at, name, status) SELECT id, created_by_id, language_id, mode_id, type_id, created_at, name, 0 FROM __temp__nomenclature');
        $this->addSql('DROP TABLE __temp__nomenclature');
        $this->addSql('CREATE INDEX IDX_799A3652C54C8C93 ON nomenclature (type_id)');
        $this->addSql('CREATE INDEX IDX_799A365277E5854A ON nomenclature (mode_id)');
        $this->addSql('CREATE INDEX IDX_799A365282F1BAF4 ON nomenclature (language_id)');
        $this->addSql('CREATE INDEX IDX_799A3652B03A8386 ON nomenclature (created_by_id)');
        $this->addSql('DROP INDEX IDX_125B3C73811FBB08');
        $this->addSql('DROP INDEX IDX_125B3C7390BFD4B8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__nomenclature_picture_set AS SELECT nomenclature_id, picture_set_id FROM nomenclature_picture_set');
        $this->addSql('DROP TABLE nomenclature_picture_set');
        $this->addSql('CREATE TABLE nomenclature_picture_set (nomenclature_id INTEGER NOT NULL, picture_set_id INTEGER NOT NULL, PRIMARY KEY(nomenclature_id, picture_set_id), CONSTRAINT FK_125B3C7390BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_125B3C73811FBB08 FOREIGN KEY (picture_set_id) REFERENCES picture_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO nomenclature_picture_set (nomenclature_id, picture_set_id) SELECT nomenclature_id, picture_set_id FROM __temp__nomenclature_picture_set');
        $this->addSql('DROP TABLE __temp__nomenclature_picture_set');
        $this->addSql('CREATE INDEX IDX_125B3C73811FBB08 ON nomenclature_picture_set (picture_set_id)');
        $this->addSql('CREATE INDEX IDX_125B3C7390BFD4B8 ON nomenclature_picture_set (nomenclature_id)');
        $this->addSql('DROP INDEX IDX_C53D045F12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, category_id, name, updated_at FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, updated_at DATETIME NOT NULL, CONSTRAINT FK_C53D045F12469DE2 FOREIGN KEY (category_id) REFERENCES image_category (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, category_id, name, updated_at) SELECT id, category_id, name, updated_at FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F12469DE2 ON image (category_id)');
        $this->addSql('DROP INDEX IDX_161498D382F1BAF4');
        $this->addSql('DROP INDEX IDX_161498D33DA5256D');
        $this->addSql('DROP INDEX IDX_161498D390BFD4B8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__card AS SELECT id, nomenclature_id, image_id, language_id, label, description, description_with_gaps FROM card');
        $this->addSql('DROP TABLE card');
        $this->addSql('CREATE TABLE card (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nomenclature_id INTEGER DEFAULT NULL, image_id INTEGER NOT NULL, language_id INTEGER NOT NULL, label VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, description_with_gaps CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_161498D390BFD4B8 FOREIGN KEY (nomenclature_id) REFERENCES nomenclature (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_161498D33DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_161498D382F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO card (id, nomenclature_id, image_id, language_id, label, description, description_with_gaps) SELECT id, nomenclature_id, image_id, language_id, label, description, description_with_gaps FROM __temp__card');
        $this->addSql('DROP TABLE __temp__card');
        $this->addSql('CREATE INDEX IDX_161498D382F1BAF4 ON card (language_id)');
        $this->addSql('CREATE INDEX IDX_161498D33DA5256D ON card (image_id)');
        $this->addSql('CREATE INDEX IDX_161498D390BFD4B8 ON card (nomenclature_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_161498D390BFD4B8');
        $this->addSql('DROP INDEX IDX_161498D33DA5256D');
        $this->addSql('DROP INDEX IDX_161498D382F1BAF4');
        $this->addSql('CREATE TEMPORARY TABLE __temp__card AS SELECT id, nomenclature_id, image_id, language_id, label, description, description_with_gaps FROM card');
        $this->addSql('DROP TABLE card');
        $this->addSql('CREATE TABLE card (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nomenclature_id INTEGER DEFAULT NULL, image_id INTEGER NOT NULL, language_id INTEGER NOT NULL, label VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, description_with_gaps CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO card (id, nomenclature_id, image_id, language_id, label, description, description_with_gaps) SELECT id, nomenclature_id, image_id, language_id, label, description, description_with_gaps FROM __temp__card');
        $this->addSql('DROP TABLE __temp__card');
        $this->addSql('CREATE INDEX IDX_161498D390BFD4B8 ON card (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_161498D33DA5256D ON card (image_id)');
        $this->addSql('CREATE INDEX IDX_161498D382F1BAF4 ON card (language_id)');
        $this->addSql('DROP INDEX IDX_C53D045F12469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, category_id, name, updated_at FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO image (id, category_id, name, updated_at) SELECT id, category_id, name, updated_at FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE INDEX IDX_C53D045F12469DE2 ON image (category_id)');
        $this->addSql('DROP INDEX IDX_799A3652B03A8386');
        $this->addSql('DROP INDEX IDX_799A365282F1BAF4');
        $this->addSql('DROP INDEX IDX_799A365277E5854A');
        $this->addSql('DROP INDEX IDX_799A3652C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__nomenclature AS SELECT id, created_by_id, language_id, mode_id, type_id, created_at, name FROM nomenclature');
        $this->addSql('DROP TABLE nomenclature');
        $this->addSql('CREATE TABLE nomenclature (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER NOT NULL, language_id INTEGER NOT NULL, mode_id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO nomenclature (id, created_by_id, language_id, mode_id, type_id, created_at, name) SELECT id, created_by_id, language_id, mode_id, type_id, created_at, name FROM __temp__nomenclature');
        $this->addSql('DROP TABLE __temp__nomenclature');
        $this->addSql('CREATE INDEX IDX_799A3652B03A8386 ON nomenclature (created_by_id)');
        $this->addSql('CREATE INDEX IDX_799A365282F1BAF4 ON nomenclature (language_id)');
        $this->addSql('CREATE INDEX IDX_799A365277E5854A ON nomenclature (mode_id)');
        $this->addSql('CREATE INDEX IDX_799A3652C54C8C93 ON nomenclature (type_id)');
        $this->addSql('DROP INDEX IDX_125B3C7390BFD4B8');
        $this->addSql('DROP INDEX IDX_125B3C73811FBB08');
        $this->addSql('CREATE TEMPORARY TABLE __temp__nomenclature_picture_set AS SELECT nomenclature_id, picture_set_id FROM nomenclature_picture_set');
        $this->addSql('DROP TABLE nomenclature_picture_set');
        $this->addSql('CREATE TABLE nomenclature_picture_set (nomenclature_id INTEGER NOT NULL, picture_set_id INTEGER NOT NULL, PRIMARY KEY(nomenclature_id, picture_set_id))');
        $this->addSql('INSERT INTO nomenclature_picture_set (nomenclature_id, picture_set_id) SELECT nomenclature_id, picture_set_id FROM __temp__nomenclature_picture_set');
        $this->addSql('DROP TABLE __temp__nomenclature_picture_set');
        $this->addSql('CREATE INDEX IDX_125B3C7390BFD4B8 ON nomenclature_picture_set (nomenclature_id)');
        $this->addSql('CREATE INDEX IDX_125B3C73811FBB08 ON nomenclature_picture_set (picture_set_id)');
    }
}

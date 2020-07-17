<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628120129 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE TypeDocument (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_6547BD50ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE TypeDocument ADD CONSTRAINT FK_6547BD50ED5CA9E6 FOREIGN KEY (service_id) REFERENCES Departement (id)');
        $this->addSql('DROP TABLE type_document');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1596AD8AED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8AED5CA9E6 FOREIGN KEY (service_id) REFERENCES departement (id)');
        $this->addSql('DROP TABLE TypeDocument');
    }
}

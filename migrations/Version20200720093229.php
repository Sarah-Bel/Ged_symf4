<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720093229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD createdby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76F0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76F0B5AF0B ON document (createdby_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76F0B5AF0B');
        $this->addSql('DROP INDEX IDX_D8698A76F0B5AF0B ON document');
        $this->addSql('ALTER TABLE document DROP createdby_id');
    }
}

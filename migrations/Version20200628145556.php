<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200628145556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD nomdocument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A13B0838 FOREIGN KEY (nomdocument_id) REFERENCES TypeDocument (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76A13B0838 ON document (nomdocument_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A13B0838');
        $this->addSql('DROP INDEX IDX_D8698A76A13B0838 ON document');
        $this->addSql('ALTER TABLE document DROP nomdocument_id');
    }
}

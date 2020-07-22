<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720144346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement ADD editby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_47EAD4B44604EFFC FOREIGN KEY (editby_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_47EAD4B44604EFFC ON departement (editby_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Departement DROP FOREIGN KEY FK_47EAD4B44604EFFC');
        $this->addSql('DROP INDEX IDX_47EAD4B44604EFFC ON Departement');
        $this->addSql('ALTER TABLE Departement DROP editby_id');
    }
}

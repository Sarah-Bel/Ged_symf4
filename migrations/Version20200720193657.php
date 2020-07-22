<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720193657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE typedocument ADD createdby_id INT DEFAULT NULL, ADD editby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_6547BD50F0B5AF0B FOREIGN KEY (createdby_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE typedocument ADD CONSTRAINT FK_6547BD504604EFFC FOREIGN KEY (editby_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6547BD50F0B5AF0B ON typedocument (createdby_id)');
        $this->addSql('CREATE INDEX IDX_6547BD504604EFFC ON typedocument (editby_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE TypeDocument DROP FOREIGN KEY FK_6547BD50F0B5AF0B');
        $this->addSql('ALTER TABLE TypeDocument DROP FOREIGN KEY FK_6547BD504604EFFC');
        $this->addSql('DROP INDEX IDX_6547BD50F0B5AF0B ON TypeDocument');
        $this->addSql('DROP INDEX IDX_6547BD504604EFFC ON TypeDocument');
        $this->addSql('ALTER TABLE TypeDocument DROP createdby_id, DROP editby_id');
    }
}

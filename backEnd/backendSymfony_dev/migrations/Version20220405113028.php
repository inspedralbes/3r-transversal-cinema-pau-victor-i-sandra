<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405113028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A274DB38439E');
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A2741CCCADCB');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A274DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A2741CCCADCB FOREIGN KEY (sesion_id) REFERENCES sesion (id)');
        $this->addSql('ALTER TABLE usuario DROP username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A274DB38439E');
        $this->addSql('ALTER TABLE entrada DROP FOREIGN KEY FK_C949A2741CCCADCB');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A274DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrada ADD CONSTRAINT FK_C949A2741CCCADCB FOREIGN KEY (sesion_id) REFERENCES sesion (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario ADD username VARCHAR(50) NOT NULL');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330100520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE entrada DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE entrada CHANGE id id_entrada INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE entrada ADD PRIMARY KEY (id_entrada)');
        $this->addSql('ALTER TABLE sesion MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE sesion DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sesion CHANGE id id_sesion INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sesion ADD PRIMARY KEY (id_sesion)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entrada MODIFY id_entrada INT NOT NULL');
        $this->addSql('ALTER TABLE entrada DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE entrada CHANGE id_entrada id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE entrada ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE sesion MODIFY id_sesion INT NOT NULL');
        $this->addSql('ALTER TABLE sesion DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE sesion CHANGE id_sesion id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE sesion ADD PRIMARY KEY (id)');
    }
}

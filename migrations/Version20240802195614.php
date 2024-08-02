<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802195614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE measuring (id INT AUTO_INCREMENT NOT NULL, id_sensor_id INT NOT NULL, id_wine_id INT NOT NULL, year INT NOT NULL, colour VARCHAR(255) NOT NULL, temperature INT NOT NULL, ph INT NOT NULL, alcohol_content INT NOT NULL, INDEX IDX_ECF3A16922722538 (id_sensor_id), INDEX IDX_ECF3A169F63F1406 (id_wine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A16922722538 FOREIGN KEY (id_sensor_id) REFERENCES sensor (id)');
        $this->addSql('ALTER TABLE measuring ADD CONSTRAINT FK_ECF3A169F63F1406 FOREIGN KEY (id_wine_id) REFERENCES wine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE measuring DROP FOREIGN KEY FK_ECF3A16922722538');
        $this->addSql('ALTER TABLE measuring DROP FOREIGN KEY FK_ECF3A169F63F1406');
        $this->addSql('DROP TABLE measuring');
    }
}

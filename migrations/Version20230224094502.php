<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224094502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY movie_ibfk_2');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP FOREIGN KEY FK_1D5EF26FA76ED395');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT movie_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}

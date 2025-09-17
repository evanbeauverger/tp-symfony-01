<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250917082706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_categorie (player_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_E971E30D99E6F5DF (player_id), INDEX IDX_E971E30DBCF5E72D (categorie_id), PRIMARY KEY(player_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_categorie ADD CONSTRAINT FK_E971E30D99E6F5DF FOREIGN KEY (player_id) REFERENCES tbl_players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_categorie ADD CONSTRAINT FK_E971E30DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player_categorie DROP FOREIGN KEY FK_E971E30D99E6F5DF');
        $this->addSql('ALTER TABLE player_categorie DROP FOREIGN KEY FK_E971E30DBCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE player_categorie');
    }
}

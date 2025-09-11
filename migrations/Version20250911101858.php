<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250911101858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player_games (player_id INT NOT NULL, games_id INT NOT NULL, INDEX IDX_4051507799E6F5DF (player_id), INDEX IDX_4051507797FFC673 (games_id), PRIMARY KEY(player_id, games_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_games ADD CONSTRAINT FK_4051507799E6F5DF FOREIGN KEY (player_id) REFERENCES tbl_players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_games ADD CONSTRAINT FK_4051507797FFC673 FOREIGN KEY (games_id) REFERENCES tbl_games (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player_games DROP FOREIGN KEY FK_4051507799E6F5DF');
        $this->addSql('ALTER TABLE player_games DROP FOREIGN KEY FK_4051507797FFC673');
        $this->addSql('DROP TABLE player_games');
    }
}

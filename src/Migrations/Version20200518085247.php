<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200518085247 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, charac_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, theme VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, mistery_identity VARCHAR(255) NOT NULL, attention VARCHAR(255) DEFAULT NULL, crack VARCHAR(255) DEFAULT NULL, INDEX IDX_161498D3FF03E368 (charac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `character` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, build_up VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE improvement (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, details VARCHAR(255) DEFAULT NULL, INDEX IDX_A0C03C5D4ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nemesis (id INT AUTO_INCREMENT NOT NULL, charac_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5802E483FF03E368 (charac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE power_tag (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8223D7EA4ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE story_tag (id INT AUTO_INCREMENT NOT NULL, charac_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_A74D17C9FF03E368 (charac_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weakness_tag (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AA1AA1874ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3FF03E368 FOREIGN KEY (charac_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE improvement ADD CONSTRAINT FK_A0C03C5D4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE nemesis ADD CONSTRAINT FK_5802E483FF03E368 FOREIGN KEY (charac_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE power_tag ADD CONSTRAINT FK_8223D7EA4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE story_tag ADD CONSTRAINT FK_A74D17C9FF03E368 FOREIGN KEY (charac_id) REFERENCES `character` (id)');
        $this->addSql('ALTER TABLE weakness_tag ADD CONSTRAINT FK_AA1AA1874ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE improvement DROP FOREIGN KEY FK_A0C03C5D4ACC9A20');
        $this->addSql('ALTER TABLE power_tag DROP FOREIGN KEY FK_8223D7EA4ACC9A20');
        $this->addSql('ALTER TABLE weakness_tag DROP FOREIGN KEY FK_AA1AA1874ACC9A20');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3FF03E368');
        $this->addSql('ALTER TABLE nemesis DROP FOREIGN KEY FK_5802E483FF03E368');
        $this->addSql('ALTER TABLE story_tag DROP FOREIGN KEY FK_A74D17C9FF03E368');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE `character`');
        $this->addSql('DROP TABLE improvement');
        $this->addSql('DROP TABLE nemesis');
        $this->addSql('DROP TABLE power_tag');
        $this->addSql('DROP TABLE story_tag');
        $this->addSql('DROP TABLE weakness_tag');
    }
}

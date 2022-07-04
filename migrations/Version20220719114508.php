<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220719114508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom_auteur VARCHAR(50) NOT NULL, biographie VARCHAR(255) DEFAULT NULL, prenom_auteur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapitre (id INT AUTO_INCREMENT NOT NULL, manga_id INT DEFAULT NULL, titre VARCHAR(50) NOT NULL, upload_date DATETIME NOT NULL, page LONGTEXT NOT NULL, INDEX IDX_8C62B0257B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manga (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, statut TINYINT(1) DEFAULT NULL, garde LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_765A9E03FF7747B4 (titre), INDEX IDX_765A9E0360BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manga_tag (manga_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_52E8F5BA7B6461 (manga_id), INDEX IDX_52E8F5BABAD26311 (tag_id), PRIMARY KEY(manga_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name_tag VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_manga (id INT AUTO_INCREMENT NOT NULL, manga_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_9498655B7B6461 (manga_id), INDEX IDX_9498655BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chapitre ADD CONSTRAINT FK_8C62B0257B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E0360BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE manga_tag ADD CONSTRAINT FK_52E8F5BA7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manga_tag ADD CONSTRAINT FK_52E8F5BABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE user_manga ADD CONSTRAINT FK_9498655B7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('ALTER TABLE user_manga ADD CONSTRAINT FK_9498655BA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E0360BB6FE6');
        $this->addSql('ALTER TABLE chapitre DROP FOREIGN KEY FK_8C62B0257B6461');
        $this->addSql('ALTER TABLE manga_tag DROP FOREIGN KEY FK_52E8F5BA7B6461');
        $this->addSql('ALTER TABLE user_manga DROP FOREIGN KEY FK_9498655B7B6461');
        $this->addSql('ALTER TABLE manga_tag DROP FOREIGN KEY FK_52E8F5BABAD26311');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE user_manga DROP FOREIGN KEY FK_9498655BA76ED395');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE chapitre');
        $this->addSql('DROP TABLE manga');
        $this->addSql('DROP TABLE manga_tag');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user_manga');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

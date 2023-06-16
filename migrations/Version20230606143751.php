<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606143751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, commande_id_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, prix INT NOT NULL, etat VARCHAR(50) DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_23A0E66462C4194 (commande_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, date DATETIME NOT NULL, nb_articles INT DEFAULT NULL, statut VARCHAR(50) NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_6EEAA67DDC2902E0 (client_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(100) DEFAULT NULL, texte LONGTEXT NOT NULL, date DATETIME NOT NULL, email VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, date_create DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, action VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_EDBFD5EC9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reparation (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, article_id_id INT DEFAULT NULL, description LONGTEXT NOT NULL, statut VARCHAR(50) NOT NULL, prix INT DEFAULT NULL, date_create DATETIME NOT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, INDEX IDX_8FDF219D9D86650F (user_id_id), INDEX IDX_8FDF219D8F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, commande_id_id INT DEFAULT NULL, modepaiement VARCHAR(50) NOT NULL, montant INT NOT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_723705D1462C4194 (commande_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, tel VARCHAR(50) DEFAULT NULL, adresse VARCHAR(100) DEFAULT NULL, date_create DATETIME DEFAULT NULL, date_update DATETIME DEFAULT NULL, date_delete DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DDC2902E0 FOREIGN KEY (client_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reparation ADD CONSTRAINT FK_8FDF219D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reparation ADD CONSTRAINT FK_8FDF219D8F3EC46 FOREIGN KEY (article_id_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1462C4194 FOREIGN KEY (commande_id_id) REFERENCES commande (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66462C4194');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DDC2902E0');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC9D86650F');
        $this->addSql('ALTER TABLE reparation DROP FOREIGN KEY FK_8FDF219D9D86650F');
        $this->addSql('ALTER TABLE reparation DROP FOREIGN KEY FK_8FDF219D8F3EC46');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1462C4194');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE reparation');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

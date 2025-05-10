<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430015829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE approvisionnement (id INT AUTO_INCREMENT NOT NULL, consommable_id INT DEFAULT NULL, creerpar_id INT DEFAULT NULL, created DATETIME NOT NULL, quantite VARCHAR(255) DEFAULT NULL, montant VARCHAR(255) NOT NULL, INDEX IDX_516C3FAAC9CEB381 (consommable_id), INDEX IDX_516C3FAA5243984F (creerpar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, creerpar_id INT DEFAULT NULL, nom_client VARCHAR(100) DEFAULT NULL, telephone_client VARCHAR(20) NOT NULL, statut VARCHAR(15) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, INDEX IDX_C74404555243984F (creerpar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, creerpar_id INT DEFAULT NULL, statutcommande VARCHAR(20) NOT NULL, prixcommande VARCHAR(20) NOT NULL, created DATETIME NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_6EEAA67D19EB6921 (client_id), INDEX IDX_6EEAA67D5243984F (creerpar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consommable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, typeduconsommable VARCHAR(255) DEFAULT NULL, typepapier VARCHAR(255) DEFAULT NULL, formatsupport VARCHAR(255) DEFAULT NULL, prixunit VARCHAR(255) DEFAULT NULL, qtedispo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detailcommande (id INT AUTO_INCREMENT NOT NULL, consommable_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, prix VARCHAR(255) DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL, create_alt DATETIME DEFAULT NULL, qteconsommable VARCHAR(255) DEFAULT NULL, qtecommande VARCHAR(255) DEFAULT NULL, INDEX IDX_7D6DC7D5C9CEB381 (consommable_id), INDEX IDX_7D6DC7D582EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, montant VARCHAR(255) DEFAULT NULL, moyenpaiemant VARCHAR(255) DEFAULT NULL, datefacture DATE DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, statut VARCHAR(255) DEFAULT NULL, resteapayer VARCHAR(255) DEFAULT NULL, INDEX IDX_FE86641082EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, consommable_id INT DEFAULT NULL, stock VARCHAR(20) DEFAULT NULL, datemisajourstock DATE DEFAULT NULL, INDEX IDX_4B36566082EA2E54 (commande_id), INDEX IDX_4B365660C9CEB381 (consommable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, poste VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_UUID (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE approvisionnement ADD CONSTRAINT FK_516C3FAAC9CEB381 FOREIGN KEY (consommable_id) REFERENCES consommable (id)');
        $this->addSql('ALTER TABLE approvisionnement ADD CONSTRAINT FK_516C3FAA5243984F FOREIGN KEY (creerpar_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404555243984F FOREIGN KEY (creerpar_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D5243984F FOREIGN KEY (creerpar_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE detailcommande ADD CONSTRAINT FK_7D6DC7D5C9CEB381 FOREIGN KEY (consommable_id) REFERENCES consommable (id)');
        $this->addSql('ALTER TABLE detailcommande ADD CONSTRAINT FK_7D6DC7D582EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B36566082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B365660C9CEB381 FOREIGN KEY (consommable_id) REFERENCES consommable (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE approvisionnement DROP FOREIGN KEY FK_516C3FAAC9CEB381');
        $this->addSql('ALTER TABLE approvisionnement DROP FOREIGN KEY FK_516C3FAA5243984F');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404555243984F');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D5243984F');
        $this->addSql('ALTER TABLE detailcommande DROP FOREIGN KEY FK_7D6DC7D5C9CEB381');
        $this->addSql('ALTER TABLE detailcommande DROP FOREIGN KEY FK_7D6DC7D582EA2E54');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B36566082EA2E54');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B365660C9CEB381');
        $this->addSql('DROP TABLE approvisionnement');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE consommable');
        $this->addSql('DROP TABLE detailcommande');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

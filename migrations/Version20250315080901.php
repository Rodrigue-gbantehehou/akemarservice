<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250315080901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE approvisionnement CHANGE quantite quantite VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE nom_client nom_client VARCHAR(100) DEFAULT NULL, CHANGE statut statut VARCHAR(15) DEFAULT NULL, CHANGE adresse adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE consommable CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE typeduconsommable typeduconsommable VARCHAR(255) DEFAULT NULL, CHANGE typepapier typepapier VARCHAR(255) DEFAULT NULL, CHANGE formatsupport formatsupport VARCHAR(255) DEFAULT NULL, CHANGE prixunit prixunit VARCHAR(255) DEFAULT NULL, CHANGE qtedispo qtedispo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE detailcommande CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE prix prix VARCHAR(255) DEFAULT NULL, CHANGE dimension dimension VARCHAR(255) DEFAULT NULL, CHANGE create_alt create_alt DATETIME DEFAULT NULL, CHANGE qteconsommable qteconsommable VARCHAR(255) DEFAULT NULL, CHANGE qtecommande qtecommande VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE facture CHANGE reference reference VARCHAR(255) DEFAULT NULL, CHANGE montant montant VARCHAR(255) DEFAULT NULL, CHANGE moyenpaiemant moyenpaiemant VARCHAR(255) DEFAULT NULL, CHANGE datefacture datefacture DATE DEFAULT NULL, CHANGE tva tva DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE stock CHANGE stock stock VARCHAR(20) DEFAULT NULL, CHANGE datemisajourstock datemisajourstock DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE prenom prenom VARCHAR(255) DEFAULT NULL, CHANGE mail mail VARCHAR(255) DEFAULT NULL, CHANGE poste poste VARCHAR(255) DEFAULT NULL, CHANGE telephone telephone VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE approvisionnement CHANGE quantite quantite VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE client CHANGE nom_client nom_client VARCHAR(100) DEFAULT \'NULL\', CHANGE statut statut VARCHAR(15) DEFAULT \'NULL\', CHANGE adresse adresse VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE consommable CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\', CHANGE typeduconsommable typeduconsommable VARCHAR(255) DEFAULT \'NULL\', CHANGE typepapier typepapier VARCHAR(255) DEFAULT \'NULL\', CHANGE formatsupport formatsupport VARCHAR(255) DEFAULT \'NULL\', CHANGE prixunit prixunit VARCHAR(255) DEFAULT \'NULL\', CHANGE qtedispo qtedispo VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE detailcommande CHANGE description description VARCHAR(255) DEFAULT \'NULL\', CHANGE type type VARCHAR(255) DEFAULT \'NULL\', CHANGE prix prix VARCHAR(255) DEFAULT \'NULL\', CHANGE dimension dimension VARCHAR(255) DEFAULT \'NULL\', CHANGE create_alt create_alt DATETIME DEFAULT \'NULL\', CHANGE qteconsommable qteconsommable VARCHAR(255) DEFAULT \'NULL\', CHANGE qtecommande qtecommande VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE facture CHANGE reference reference VARCHAR(255) DEFAULT \'NULL\', CHANGE montant montant VARCHAR(255) DEFAULT \'NULL\', CHANGE moyenpaiemant moyenpaiemant VARCHAR(255) DEFAULT \'NULL\', CHANGE datefacture datefacture DATE DEFAULT \'NULL\', CHANGE tva tva DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE stock CHANGE stock stock VARCHAR(20) DEFAULT \'NULL\', CHANGE datemisajourstock datemisajourstock DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE nom nom VARCHAR(255) DEFAULT \'NULL\', CHANGE prenom prenom VARCHAR(255) DEFAULT \'NULL\', CHANGE mail mail VARCHAR(255) DEFAULT \'NULL\', CHANGE poste poste VARCHAR(255) DEFAULT \'NULL\', CHANGE telephone telephone VARCHAR(255) DEFAULT \'NULL\'');
    }
}

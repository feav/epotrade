<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200424052821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, date_naiss DATETIME NOT NULL, lieu_naiss VARCHAR(255) NOT NULL, identification_type VARCHAR(255) NOT NULL, numero_identite VARCHAR(255) NOT NULL, nationalite VARCHAR(255) NOT NULL, is_referred TINYINT(1) NOT NULL, pays VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, code_postale VARCHAR(255) NOT NULL, status_emploi VARCHAR(255) NOT NULL, revenue_annuel VARCHAR(255) NOT NULL, economie_investissement VARCHAR(255) NOT NULL, depot_estime VARCHAR(255) NOT NULL, source_fond VARCHAR(255) NOT NULL, nb_transaction VARCHAR(255) NOT NULL, qte_echange_semaine VARCHAR(255) NOT NULL, trading_plateforme VARCHAR(255) NOT NULL, type_compte VARCHAR(255) NOT NULL, devise VARCHAR(255) NOT NULL, cgu TINYINT(1) NOT NULL, identite_doc VARCHAR(255) NOT NULL, residence_doc VARCHAR(255) NOT NULL, INDEX IDX_29791883A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE prenom prenom VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE information');
        $this->addSql('ALTER TABLE user CHANGE prenom prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}

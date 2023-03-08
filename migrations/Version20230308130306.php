<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308130306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(155) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT NOT NULL, name VARCHAR(255) NOT NULL, siret VARCHAR(50) NOT NULL, location VARCHAR(255) DEFAULT NULL, employees INT NOT NULL, publique TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_activity (company_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_B4E31C37979B1AD6 (company_id), INDEX IDX_B4E31C3781C06096 (activity_id), PRIMARY KEY(company_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer (id INT NOT NULL, name VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, experience INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE developer_speciality (developer_id INT NOT NULL, speciality_id INT NOT NULL, INDEX IDX_3969F84864DD9267 (developer_id), INDEX IDX_3969F8483B5A08D7 (speciality_id), PRIMARY KEY(developer_id, speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speciality (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, presentation VARCHAR(500) DEFAULT NULL, telephone VARCHAR(30) DEFAULT NULL, mail VARCHAR(150) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649450FF010 (telephone), UNIQUE INDEX UNIQ_8D93D6495126AC48 (mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company ADD CONSTRAINT FK_4FBF094FBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_activity ADD CONSTRAINT FK_B4E31C37979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE company_activity ADD CONSTRAINT FK_B4E31C3781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer ADD CONSTRAINT FK_65FB8B9ABF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_speciality ADD CONSTRAINT FK_3969F84864DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE developer_speciality ADD CONSTRAINT FK_3969F8483B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company DROP FOREIGN KEY FK_4FBF094FBF396750');
        $this->addSql('ALTER TABLE company_activity DROP FOREIGN KEY FK_B4E31C37979B1AD6');
        $this->addSql('ALTER TABLE company_activity DROP FOREIGN KEY FK_B4E31C3781C06096');
        $this->addSql('ALTER TABLE developer DROP FOREIGN KEY FK_65FB8B9ABF396750');
        $this->addSql('ALTER TABLE developer_speciality DROP FOREIGN KEY FK_3969F84864DD9267');
        $this->addSql('ALTER TABLE developer_speciality DROP FOREIGN KEY FK_3969F8483B5A08D7');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE company_activity');
        $this->addSql('DROP TABLE developer');
        $this->addSql('DROP TABLE developer_speciality');
        $this->addSql('DROP TABLE speciality');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

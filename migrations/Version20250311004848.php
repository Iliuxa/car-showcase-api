<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250311004848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statement (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, credit_program_id INT NOT NULL, initial_payment INT NOT NULL, loan_term INT NOT NULL, INDEX IDX_C0DB5176C3C6F69F (car_id), INDEX IDX_C0DB5176CDC0BCB4 (credit_program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statement ADD CONSTRAINT FK_C0DB5176C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE statement ADD CONSTRAINT FK_C0DB5176CDC0BCB4 FOREIGN KEY (credit_program_id) REFERENCES credit_program (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statement DROP FOREIGN KEY FK_C0DB5176C3C6F69F');
        $this->addSql('ALTER TABLE statement DROP FOREIGN KEY FK_C0DB5176CDC0BCB4');
        $this->addSql('DROP TABLE statement');
    }
}

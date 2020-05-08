<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180906074409 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name VARCHAR(35) DEFAULT NULL, last_name VARCHAR(35) DEFAULT NULL, user_name VARCHAR(35) DEFAULT NULL, email VARCHAR(75) NOT NULL, password VARCHAR(255) DEFAULT NULL, salt VARCHAR(4) DEFAULT NULL, birthday DATE DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT "trial", createdAT DATETIME, updatedAT DATETIME, deletedAT DATETIME)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE users');
    }
}

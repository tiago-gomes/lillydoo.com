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
        $this->addSql('CREATE TABLE address (id INTEGER PRIMARY KEY AUTOINCREMENT,
		first_name VARCHAR(35) DEFAULT NULL, 
		last_name VARCHAR(35) DEFAULT NULL, 
		user_name VARCHAR(35) DEFAULT NULL, 
		email VARCHAR(75) NOT NULL, 
		birthday DATE DEFAULT NULL, 
		street_address VARCHAR(125) DEFAULT NULL, 
		zip VARCHAR(75) DEFAULT NULL,
		city VARCHAR(75) DEFAULT NULL,
		country VARCHAR(75) DEFAULT NULL, 
		phone VARCHAR(75) DEFAULT NULL, 
		picture VARCHAR(125) DEFAULT NULL, 
		createdAT DATETIME, 
		updatedAT DATETIME, 
		deletedAT DATETIME)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE address');
    }
}

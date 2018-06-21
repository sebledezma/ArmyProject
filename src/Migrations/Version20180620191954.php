<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180620191954 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE E_Installed_B DROP FOREIGN KEY E_Installed_B_fk1');
        $this->addSql('ALTER TABLE V_Assigned_B DROP FOREIGN KEY V_Assigned_B_fk0');
        $this->addSql('ALTER TABLE E_Installed_B DROP FOREIGN KEY E_Installed_B_fk0');
        $this->addSql('ALTER TABLE Base DROP FOREIGN KEY Base_fk0');
        $this->addSql('ALTER TABLE Mission DROP FOREIGN KEY Mission_fk1');
        $this->addSql('ALTER TABLE V_Assigned_M DROP FOREIGN KEY V_Assigned_M_fk1');
        $this->addSql('ALTER TABLE S_Member_T DROP FOREIGN KEY S_Member_T_fk0');
        $this->addSql('ALTER TABLE Mission DROP FOREIGN KEY Mission_fk0');
        $this->addSql('ALTER TABLE S_Member_T DROP FOREIGN KEY S_Member_T_fk1');
        $this->addSql('ALTER TABLE V_Assigned_B DROP FOREIGN KEY V_Assigned_B_fk1');
        $this->addSql('ALTER TABLE V_Assigned_M DROP FOREIGN KEY V_Assigned_M_fk0');
        $this->addSql('DROP TABLE Base');
        $this->addSql('DROP TABLE E_Installed_B');
        $this->addSql('DROP TABLE Equipment');
        $this->addSql('DROP TABLE Location');
        $this->addSql('DROP TABLE Mission');
        $this->addSql('DROP TABLE S_Member_T');
        $this->addSql('DROP TABLE Soldier');
        $this->addSql('DROP TABLE Team');
        $this->addSql('DROP TABLE V_Assigned_B');
        $this->addSql('DROP TABLE V_Assigned_M');
        $this->addSql('DROP TABLE Vehicule');
        $this->addSql('ALTER TABLE user CHANGE user_id user_id INT AUTO_INCREMENT NOT NULL COMMENT \'User ID\', CHANGE user_mail user_mail VARCHAR(190) NOT NULL COMMENT \'Email address\', CHANGE user_pass user_pass VARCHAR(200) NOT NULL COMMENT \'User password\', CHANGE user_registered user_registered DATETIME NOT NULL COMMENT \'Registration date\', CHANGE user_group user_group VARCHAR(100) NOT NULL COMMENT \'Root rank\'');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6492BA7E081 ON user (user_mail)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Base (baseID INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci, locationID INT NOT NULL, creation DATE NOT NULL, destruction DATE DEFAULT NULL, INDEX Base_fk0 (locationID), PRIMARY KEY(baseID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE E_Installed_B (equipmentID INT NOT NULL, baseID INT NOT NULL, creation DATE NOT NULL, INDEX E_Installed_B_fk0 (equipmentID), INDEX E_Installed_B_fk1 (baseID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Equipment (equipmentID INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, purpose VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(equipmentID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Location (locationID INT AUTO_INCREMENT NOT NULL, country VARCHAR(25) NOT NULL COLLATE utf8mb4_general_ci, city VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, street VARCHAR(100) NOT NULL COLLATE utf8mb4_general_ci, coordinates VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(locationID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Mission (missionID INT AUTO_INCREMENT NOT NULL, teamID INT NOT NULL, locationID INT NOT NULL, start DATETIME NOT NULL, end DATETIME NOT NULL, INDEX Mission_fk0 (teamID), INDEX Mission_fk1 (locationID), PRIMARY KEY(missionID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE S_Member_T (soldierID INT NOT NULL, teamID INT NOT NULL, since DATE NOT NULL, until DATE DEFAULT NULL, INDEX S_Member_T_fk0 (soldierID), INDEX S_Member_T_fk1 (teamID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Soldier (soldierID INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, lastName VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, dateBirth DATE NOT NULL, bloodType VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, speciality VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, address VARCHAR(250) NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(soldierID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Team (teamID INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, codeName VARCHAR(20) NOT NULL COLLATE utf8mb4_general_ci, type VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(teamID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE V_Assigned_B (baseID INT NOT NULL, vehiculeID INT NOT NULL, since DATE NOT NULL, until DATE DEFAULT NULL, quantity INT NOT NULL, INDEX V_Assigned_B_fk0 (baseID), INDEX V_Assigned_B_fk1 (vehiculeID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE V_Assigned_M (vehiculeID INT NOT NULL, missionID INT NOT NULL, since DATETIME NOT NULL, until DATETIME NOT NULL, quantity INT NOT NULL, INDEX V_Assigned_M_fk0 (vehiculeID), INDEX V_Assigned_M_fk1 (missionID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Vehicule (vehiculeID INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, type VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, purpose VARCHAR(50) NOT NULL COLLATE utf8mb4_general_ci, creation DATE NOT NULL, state VARCHAR(20) NOT NULL COLLATE utf8mb4_general_ci, PRIMARY KEY(vehiculeID)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Base ADD CONSTRAINT Base_fk0 FOREIGN KEY (locationID) REFERENCES Location (locationID)');
        $this->addSql('ALTER TABLE E_Installed_B ADD CONSTRAINT E_Installed_B_fk0 FOREIGN KEY (equipmentID) REFERENCES Equipment (equipmentID)');
        $this->addSql('ALTER TABLE E_Installed_B ADD CONSTRAINT E_Installed_B_fk1 FOREIGN KEY (baseID) REFERENCES Base (baseID)');
        $this->addSql('ALTER TABLE Mission ADD CONSTRAINT Mission_fk0 FOREIGN KEY (teamID) REFERENCES Team (teamID)');
        $this->addSql('ALTER TABLE Mission ADD CONSTRAINT Mission_fk1 FOREIGN KEY (locationID) REFERENCES Location (locationID)');
        $this->addSql('ALTER TABLE S_Member_T ADD CONSTRAINT S_Member_T_fk0 FOREIGN KEY (soldierID) REFERENCES Soldier (soldierID)');
        $this->addSql('ALTER TABLE S_Member_T ADD CONSTRAINT S_Member_T_fk1 FOREIGN KEY (teamID) REFERENCES Team (teamID)');
        $this->addSql('ALTER TABLE V_Assigned_B ADD CONSTRAINT V_Assigned_B_fk0 FOREIGN KEY (baseID) REFERENCES Base (baseID)');
        $this->addSql('ALTER TABLE V_Assigned_B ADD CONSTRAINT V_Assigned_B_fk1 FOREIGN KEY (vehiculeID) REFERENCES Vehicule (vehiculeID)');
        $this->addSql('ALTER TABLE V_Assigned_M ADD CONSTRAINT V_Assigned_M_fk0 FOREIGN KEY (vehiculeID) REFERENCES Vehicule (vehiculeID)');
        $this->addSql('ALTER TABLE V_Assigned_M ADD CONSTRAINT V_Assigned_M_fk1 FOREIGN KEY (missionID) REFERENCES Mission (missionID)');
        $this->addSql('DROP INDEX UNIQ_8D93D6492BA7E081 ON user');
        $this->addSql('ALTER TABLE user CHANGE user_id user_id INT AUTO_INCREMENT NOT NULL, CHANGE user_mail user_mail VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE user_pass user_pass VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE user_registered user_registered DATETIME NOT NULL, CHANGE user_group user_group VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}

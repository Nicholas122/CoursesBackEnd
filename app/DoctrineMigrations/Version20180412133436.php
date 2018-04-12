<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412133436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, user_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, sub_title VARCHAR(150) NOT NULL, language VARCHAR(200) NOT NULL, status ENUM(\'draft\', \'publish\') DEFAULT NULL COMMENT \'(DC2Type:enum_course_status_type)\', instructional_level ENUM(\'all\', \'introductory\', \'intermediate\', \'advanced\') DEFAULT NULL COMMENT \'(DC2Type:enum_instructional_level_type)\', summary TEXT NOT NULL, logo VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, session ENUM(\'withoutEnrollment\', \'withEnrollment\') DEFAULT NULL COMMENT \'(DC2Type:enum_session_type)\', creation_date DATETIME NOT NULL, INDEX IDX_169E6FB912469DE2 (category_id), INDEX IDX_169E6FB9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB912469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE course');
    }
}

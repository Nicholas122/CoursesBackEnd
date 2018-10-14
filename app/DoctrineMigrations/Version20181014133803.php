<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181014133803 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE test_result (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, user_id INT DEFAULT NULL, result DOUBLE PRECISION NOT NULL, pass_date DATETIME NOT NULL, INDEX IDX_84B3C63D1E5D0459 (test_id), INDEX IDX_84B3C63DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question_result (id INT AUTO_INCREMENT NOT NULL, test_result_id INT DEFAULT NULL, question_id INT DEFAULT NULL, answer_id INT DEFAULT NULL, INDEX IDX_1437EE1B853A2189 (test_result_id), INDEX IDX_1437EE1B1E27F6BF (question_id), INDEX IDX_1437EE1BAA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test_result ADD CONSTRAINT FK_84B3C63D1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_result ADD CONSTRAINT FK_84B3C63DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_result ADD CONSTRAINT FK_1437EE1B853A2189 FOREIGN KEY (test_result_id) REFERENCES test_result (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_result ADD CONSTRAINT FK_1437EE1B1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_result ADD CONSTRAINT FK_1437EE1BAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_result DROP FOREIGN KEY FK_1437EE1B853A2189');
        $this->addSql('DROP TABLE test_result');
        $this->addSql('DROP TABLE question_result');
    }
}

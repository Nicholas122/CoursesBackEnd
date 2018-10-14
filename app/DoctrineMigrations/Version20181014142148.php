<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181014142148 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE grade_question (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, grade_test_id INT DEFAULT NULL, user_input_answer LONGTEXT NOT NULL, INDEX IDX_F80987881E27F6BF (question_id), INDEX IDX_F8098788E41096BB (grade_test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade_test (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, student_id INT DEFAULT NULL, INDEX IDX_761D331C1E5D0459 (test_id), INDEX IDX_761D331C41807E1D (teacher_id), INDEX IDX_761D331CCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grade_question ADD CONSTRAINT FK_F80987881E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_question ADD CONSTRAINT FK_F8098788E41096BB FOREIGN KEY (grade_test_id) REFERENCES grade_test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_test ADD CONSTRAINT FK_761D331C1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_test ADD CONSTRAINT FK_761D331C41807E1D FOREIGN KEY (teacher_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade_test ADD CONSTRAINT FK_761D331CCB944F1A FOREIGN KEY (student_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grade_question DROP FOREIGN KEY FK_F8098788E41096BB');
        $this->addSql('DROP TABLE grade_question');
        $this->addSql('DROP TABLE grade_test');
    }
}

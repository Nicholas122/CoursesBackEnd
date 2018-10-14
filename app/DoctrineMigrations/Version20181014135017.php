<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181014135017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_result ADD sub_question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_result ADD CONSTRAINT FK_1437EE1BFBDE8321 FOREIGN KEY (sub_question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_1437EE1BFBDE8321 ON question_result (sub_question_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE question_result DROP FOREIGN KEY FK_1437EE1BFBDE8321');
        $this->addSql('DROP INDEX IDX_1437EE1BFBDE8321 ON question_result');
        $this->addSql('ALTER TABLE question_result DROP sub_question_id');
    }
}

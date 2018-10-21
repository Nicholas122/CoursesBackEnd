<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181021142107 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grade_test ADD test_result_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grade_test ADD CONSTRAINT FK_761D331C853A2189 FOREIGN KEY (test_result_id) REFERENCES test_result (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_761D331C853A2189 ON grade_test (test_result_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grade_test DROP FOREIGN KEY FK_761D331C853A2189');
        $this->addSql('DROP INDEX IDX_761D331C853A2189 ON grade_test');
        $this->addSql('ALTER TABLE grade_test DROP test_result_id');
    }
}

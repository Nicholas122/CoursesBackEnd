<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180412140125 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO `category` (`id`, `name`) VALUES (\'1\', \'Arts and Photography\'), (\'2\', \'Business\'), (\'3\', \'Crafts and Hobbies\'), (\'4\', \'Design\'), (\'5\', \'Education\'), (\'6\', \'Games\'), (\'7\', \'Health and Fitness\'), (\'8\', \'Humanities\'), (\'9\', \'Languages\'), (\'10\', \'Lifestyle\'), (\'11\', \'Math and Science\'), (\'12\', \'Music\'), (\'13\', \'Social Sciences\'), (\'14\', \'Sports\'), (\'15\', \'Technology\'), (\'16\', \'Other\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

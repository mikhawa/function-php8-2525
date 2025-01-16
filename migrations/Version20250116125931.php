<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116125931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE link_php (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(150) NOT NULL, description VARCHAR(500) DEFAULT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE php_function_link_php (php_function_id INT UNSIGNED NOT NULL, link_php_id INT UNSIGNED NOT NULL, INDEX IDX_FE0122389693C840 (php_function_id), INDEX IDX_FE012238805968DF (link_php_id), PRIMARY KEY(php_function_id, link_php_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE php_function_link_php ADD CONSTRAINT FK_FE0122389693C840 FOREIGN KEY (php_function_id) REFERENCES php_function (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE php_function_link_php ADD CONSTRAINT FK_FE012238805968DF FOREIGN KEY (link_php_id) REFERENCES link_php (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE php_function_link_php DROP FOREIGN KEY FK_FE0122389693C840');
        $this->addSql('ALTER TABLE php_function_link_php DROP FOREIGN KEY FK_FE012238805968DF');
        $this->addSql('DROP TABLE link_php');
        $this->addSql('DROP TABLE php_function_link_php');
    }
}

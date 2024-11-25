<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125122832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances ADD CONSTRAINT check_amount_non_negative CHECK (amount >= 0.00)');
        $this->addSql('ALTER TABLE exchange_rates ADD CONSTRAINT check_exchange_rate_non_negative CHECK (exchange_rate >= 0.00)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE balances DROP CONSTRAINT check_amount_non_negative CHECK (amount >= 0.00)');
        $this->addSql('ALTER TABLE exchange_rates DROP CONSTRAINT check_exchange_rate_non_negative CHECK (exchange_rate >= 0.00)');
    }
}

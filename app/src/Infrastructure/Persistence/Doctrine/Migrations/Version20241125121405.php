<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241125121405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "accounts" (id UUID NOT NULL, created_at DATE NOT NULL, prime_currency_id UUID NOT NULL, user_id UUID NOT NULL, bank_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAC89EACF46698E0 ON "accounts" (prime_currency_id)');
        $this->addSql('CREATE INDEX IDX_CAC89EACA76ED395 ON "accounts" (user_id)');
        $this->addSql('CREATE INDEX IDX_CAC89EAC11C8FB41 ON "accounts" (bank_id)');
        $this->addSql('CREATE TABLE account_currencies (account_id UUID NOT NULL, currency_id UUID NOT NULL, PRIMARY KEY(account_id, currency_id))');
        $this->addSql('CREATE INDEX IDX_CB5FB4379B6B5FBA ON account_currencies (account_id)');
        $this->addSql('CREATE INDEX IDX_CB5FB43738248176 ON account_currencies (currency_id)');
        $this->addSql('CREATE TABLE "balances" (id UUID NOT NULL, amount NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, updated_at DATE DEFAULT NULL, created_at DATE NOT NULL, account_id UUID NOT NULL, currency_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_41A7E40F9B6B5FBA ON "balances" (account_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41A7E40F38248176 ON "balances" (currency_id)');
        $this->addSql('CREATE TABLE "banks" (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AB0637965E237E06 ON "banks" (name)');
        $this->addSql('CREATE TABLE bank_currencies (bank_id UUID NOT NULL, currency_id UUID NOT NULL, PRIMARY KEY(bank_id, currency_id))');
        $this->addSql('CREATE INDEX IDX_BE64802511C8FB41 ON bank_currencies (bank_id)');
        $this->addSql('CREATE INDEX IDX_BE64802538248176 ON bank_currencies (currency_id)');
        $this->addSql('CREATE TABLE "currencies" (id UUID NOT NULL, name VARCHAR(3) NOT NULL, updated_at DATE DEFAULT NULL, created_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C446935E237E06 ON "currencies" (name)');
        $this->addSql('CREATE TABLE "exchange_rates" (id UUID NOT NULL, bank_id VARCHAR(255) NOT NULL, exchange_rate NUMERIC(10, 2) NOT NULL, updated_at DATE DEFAULT NULL, created_at DATE NOT NULL, from_currency_id UUID NOT NULL, to_currency_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5AE3E774A66BB013 ON "exchange_rates" (from_currency_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5AE3E77416B7BF15 ON "exchange_rates" (to_currency_id)');
        $this->addSql('CREATE TABLE "users" (id UUID NOT NULL, name VARCHAR(30) NOT NULL, email VARCHAR(180) NOT NULL, roles TEXT NOT NULL, password VARCHAR(255) NOT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E95E237E06 ON "users" (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON "users" (email)');
        $this->addSql('ALTER TABLE "accounts" ADD CONSTRAINT FK_CAC89EACF46698E0 FOREIGN KEY (prime_currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "accounts" ADD CONSTRAINT FK_CAC89EACA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "accounts" ADD CONSTRAINT FK_CAC89EAC11C8FB41 FOREIGN KEY (bank_id) REFERENCES "banks" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account_currencies ADD CONSTRAINT FK_CB5FB4379B6B5FBA FOREIGN KEY (account_id) REFERENCES "accounts" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE account_currencies ADD CONSTRAINT FK_CB5FB43738248176 FOREIGN KEY (currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "balances" ADD CONSTRAINT FK_41A7E40F9B6B5FBA FOREIGN KEY (account_id) REFERENCES "accounts" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "balances" ADD CONSTRAINT FK_41A7E40F38248176 FOREIGN KEY (currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bank_currencies ADD CONSTRAINT FK_BE64802511C8FB41 FOREIGN KEY (bank_id) REFERENCES "banks" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE bank_currencies ADD CONSTRAINT FK_BE64802538248176 FOREIGN KEY (currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "exchange_rates" ADD CONSTRAINT FK_5AE3E774A66BB013 FOREIGN KEY (from_currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "exchange_rates" ADD CONSTRAINT FK_5AE3E77416B7BF15 FOREIGN KEY (to_currency_id) REFERENCES "currencies" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "accounts" DROP CONSTRAINT FK_CAC89EACF46698E0');
        $this->addSql('ALTER TABLE "accounts" DROP CONSTRAINT FK_CAC89EACA76ED395');
        $this->addSql('ALTER TABLE "accounts" DROP CONSTRAINT FK_CAC89EAC11C8FB41');
        $this->addSql('ALTER TABLE account_currencies DROP CONSTRAINT FK_CB5FB4379B6B5FBA');
        $this->addSql('ALTER TABLE account_currencies DROP CONSTRAINT FK_CB5FB43738248176');
        $this->addSql('ALTER TABLE "balances" DROP CONSTRAINT FK_41A7E40F9B6B5FBA');
        $this->addSql('ALTER TABLE "balances" DROP CONSTRAINT FK_41A7E40F38248176');
        $this->addSql('ALTER TABLE bank_currencies DROP CONSTRAINT FK_BE64802511C8FB41');
        $this->addSql('ALTER TABLE bank_currencies DROP CONSTRAINT FK_BE64802538248176');
        $this->addSql('ALTER TABLE "exchange_rates" DROP CONSTRAINT FK_5AE3E774A66BB013');
        $this->addSql('ALTER TABLE "exchange_rates" DROP CONSTRAINT FK_5AE3E77416B7BF15');
        $this->addSql('DROP TABLE "accounts"');
        $this->addSql('DROP TABLE account_currencies');
        $this->addSql('DROP TABLE "balances"');
        $this->addSql('DROP TABLE "banks"');
        $this->addSql('DROP TABLE bank_currencies');
        $this->addSql('DROP TABLE "currencies"');
        $this->addSql('DROP TABLE "exchange_rates"');
        $this->addSql('DROP TABLE "users"');
    }
}

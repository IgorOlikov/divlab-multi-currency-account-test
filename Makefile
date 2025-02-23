test:
	docker compose run --rm cli php bin/phpunit

test-migration:
	docker compose run --rm cli bin/console doctrine:migrations:migrate --env=test --no-interaction

test-load-fixtures:
	docker compose run --rm cli bin/console doctrine:fixtures:load --purge-with-truncate --env=test --no-interaction

test-purge-fixtures:
	docker compose run --rm cli bin/console app:purge-fixtures-rows --env=test

test-drop-test-database:
	docker compose run --rm cli bin/console doctrine:database:drop --force --env=test --no-interaction

test-create-test-database:
	docker compose run --rm cli bin/console doctrine:database:create --env=test --no-interaction

test-create-test-schema:
	docker compose run --rm cli bin/console doctrine:schema:create --env=test --no-interaction

cache-clear:
	docker compose run --rm cli bin/console cache:clear

token-pair:
	docker compose run --rm cli bin/console lexik:jwt:generate-keypair

composer-install:
	docker compose run --rm cli composer install

build:
	docker compose build

up:
	docker compose up -d

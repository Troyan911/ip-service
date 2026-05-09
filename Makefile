up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

bash:
	docker compose exec php bash


go:
	docker compose exec php bash

m, migrate:
	docker compose exec php php artisan migrate

mr, rollback:
	docker compose exec php php artisan migrate:rollback







console:
	docker compose exec php php bin/console


test:
	docker compose exec php php bin/phpunit tests/Unit  #--debug
	#docker compose exec php php bin/phpunit tests/Api  #--debug


db-create:
	docker compose exec php php bin/console doctrine:database:create --if-not-exists

migration:
	docker compose exec php php bin/console make:migration --no-interaction


schema-update:
	docker compose exec php php bin/console doctrine:schema:update --force

cache-clear:
	docker compose exec php php bin/console cache:clear

wreset:
	docker compose exec php php bin/console app:words:reset

fixtures:
	docker compose exec php php bin/console app:fixtures:reset
	docker compose exec php php bin/console doctrine:fixtures:load --no-interaction


elastica-create:
	docker compose exec php php bin/console fos:elastica:create

elastica-reset:
	docker compose exec php php bin/console fos:elastica:reset

elastica-populate:
	docker compose exec php php bin/console fos:elastica:populate

setup:
	docker compose exec php php bin/console doctrine:database:create --if-not-exists
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
	docker compose exec php php bin/console cache:clear

jwt:
	docker compose exec php php bin/console lexik:jwt:generate-keypair

composer:
	docker compose exec php composer install

setup: composer migrate fixtures jwt cache


route:
	docker compose exec php php bin/console debug:route

f:fixtures

m: migrate


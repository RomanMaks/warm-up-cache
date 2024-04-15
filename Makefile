# Install project
setup: build up composer-install migrate seed
	docker compose exec app php artisan key:generate

build:
	docker compose build

up:
	docker compose up -d

down:
	docker compose down

composer-install:
	docker compose exec app composer install

migrate:
	docker compose exec app php artisan migrate

seed:
	docker compose exec app php artisan db:seed

bash:
	docker compose exec app bash

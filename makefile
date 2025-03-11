.PHONY: install migrate fixtures test-db-create test-migrate

install:
	composer install --no-interaction

migrate:
	php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	php bin/console doctrine:fixtures:load --no-interaction

deploy: install migrate fixtures
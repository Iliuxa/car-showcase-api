.PHONY: install migrate fixtures test-db-create test-migrate

#install:
#	composer install --no-interaction

migrate:
	php bin/console doctrine:migrations:migrate --no-interaction

fixtures:
	php bin/console doctrine:fixtures:load --no-interaction

#test-db-create:
#	php bin/console doctrine:database:create --no-interaction --env=test
#
#test-migrate:
#	php bin/console doctrine:migrations:migrate --no-interaction --env=test

deploy: install migrate fixtures test-db-create test-migrate
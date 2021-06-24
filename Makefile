start:
	docker-compose up -d

test:
	php bin/console doctrine:database:create --if-not-exists --env=test
	php bin/console doctrine:schema:update --force --env=test
	php bin/phpunit

stop:
	docker-compose stop

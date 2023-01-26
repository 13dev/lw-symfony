#var
DOCKER_COMPOSE = docker-compose -f ./docker-compose.yml --env-file ./.env
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

ps:
	${DOCKER_COMPOSE} ps

logs:
	${DOCKER_COMPOSE} logs -f

down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

restart:
	make stop start


##################
# App
##################

bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
test:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/phpunit
jwt:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console lexik:jwt:generate-keypair
cache:
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear
	docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear --env=test

#Code analysis
phpstan:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/phpstan analyse src tests -c phpstan.neon

deptrac:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrac-layers.yaml
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrac-modules.yaml

fix:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix

fix-diff:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix --dry-run --diff

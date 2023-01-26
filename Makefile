.DEFAULT_GOAL := help
.PHONY: build start stop up ps logs down restart bash test cache phpstan deptrac fix fix-diff help

#var
DOCKER_COMPOSE = docker-compose -f ./docker-compose.yml --env-file ./.env
DC_PHP_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

build: ## Build docker container
	${DOCKER_COMPOSE} build

start: ## Start docker container
	${DOCKER_COMPOSE} start

stop: ## Stop docker container
	${DOCKER_COMPOSE} stop

up: ## Up docker container
	${DOCKER_COMPOSE} up -d --remove-orphans

ps: ## Check status of docker containers
	${DOCKER_COMPOSE} ps

logs: ## Check logs of containers
	${DOCKER_COMPOSE} logs -f

down: ## Remove docker containers
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

restart: ## Restart docker containers
	make stop start

#app
bash: ## Execute bash in php-fpm container
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
test: ## Run phpunit tests
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/phpunit
cache: ## Clear cache
	docker-compose -f ./.docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear
	docker-compose -f ./.docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear --env=test

#Code analysis
phpstan: ## Analyse app using phpstan
	${DC_PHP_EXEC} vendor/bin/phpstan analyse src tests -c phpstan.neon

deptrac: ## Run deptrac to analyse app arch
	${DC_PHP_EXEC} vendor/bin/deptrac analyze deptrac-layers.yaml
	${DC_PHP_EXEC} vendor/bin/deptrac analyze deptrac-modules.yaml

fix: ## Run php-cs-fixer
	${DC_PHP_EXEC} vendor/bin/php-cs-fixer fix

fix-diff: ## Run php-cs-fixer with diff
	${DC_PHP_EXEC} vendor/bin/php-cs-fixer fix --dry-run --diff

help: ## Display this message
	@grep -E '^[a-zA-Z._-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

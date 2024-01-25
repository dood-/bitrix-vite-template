include .env

.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

console-php: ## Run bash (PHP) from "www-data"
	docker-compose exec -u www-data php bash

shell: console-php

console-php-root: ## Run bash (PHP) from "root"
	docker-compose exec -u root php bash

console-mysql: ## Log in to the MySQL console from default user
	docker-compose exec db mysql -u $(MYSQL_USER) --password=$(MYSQL_PASSWORD) -A $(MYSQL_DATABASE)

console-mysql-root: ## Log in to the MySQL console from "root"
	docker-compose exec db mysql -u root --password=$(MYSQL_ROOT_PASSWORD) -A $(MYSQL_DATABASE)

up: ## Up Docker-project
	docker-compose up -d

down: ## Down Docker-project
	docker-compose down --remove-orphans

stop: ## Stop Docker-project
	docker-compose stop

build: ## Build Docker-project
	docker-compose build --no-cache

ps: ## Show list containers
	docker-compose ps

default: help

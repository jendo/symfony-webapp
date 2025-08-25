#VARIABLES
RED  := $(shell tput -Txterm setaf 1)
GREEN  := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
BLUE   := $(shell tput -Txterm setaf 4)

EOL  := $(shell tput -Txterm sgr0)

PHP_SERVICE_NAME := php
PHP_DOCKER_EXEC := docker compose exec -u www-data -it ${PHP_SERVICE_NAME}
PHP_DOCKER_EXEC_XDEBUG := docker compose exec -e XDEBUG_TRIGGER=1 -u www-data -it ${PHP_SERVICE_NAME}

up:
	docker compose --env-file=.env up -d --force-recreate --build --remove-orphans

down:
	docker compose --env-file=.env down --volumes --remove-orphans

php-bash:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC) bash

php-bash-xdebug:
	@echo "${GREEN}>>> Entering php container bash${EOL}"
	@$(PHP_DOCKER_EXEC_XDEBUG) bash

composer-install:
	@echo "${GREEN}>>> Running composer install${EOL}"
	@$(PHP_DOCKER_EXEC) composer -n install --prefer-dist

composer-dump-autoload:
	@echo "${GREEN}>>> Running composer dump-autoload${EOL}"
	@$(PHP_DOCKER_EXEC) composer dump-autoload

composer-update:
	@echo "${GREEN}>>> Running composer update${EOL}"
	@$(PHP_DOCKER_EXEC) composer update

phpcs:
	@echo "${GREEN}>>> Running phpcs${EOL}"
	@$(PHP_DOCKER_EXEC) composer phpcs

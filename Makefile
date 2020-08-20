VENDOR ?= "../../../../vendor"
export PATH := $(HOME)/.composer/vendor/bin:$(PATH)

## As an alternative for linting PHP we can also setup `friendsofphp/php-cs-fixer` which is popular package
## More info: https://github.com/FriendsOfPHP/PHP-CS-Fixer

COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m

## Help
help:
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

#######################
# Package installation
#######################

install:
	@echo "  $(P) Installing dependencies"
	composer global require "squizlabs/php_codesniffer=*"
	sudo apt update; sudo apt install make inotify-tools -y

#######################
# LINTING TASKS
# * PHP Code Sniffer
# * PHP Code Beautifier and Fixer
#######################

## Display formatting issues
lint:
	phpcs

## Display a summary of formatting issues
lint-summary:
	phpcs --report=summary

## Automatically fix code formatting issues
lint-fix:
	phpcbf

#######################
# PHPUnit
#######################

## Run unit tests
tests:
	@echo "  $(P) Start unit tests"
	@$(VENDOR)/bin/phpunit -c $(VENDOR)/typo3/testing-framework/Resources/Core/Build/UnitTests.xml  Tests/Unit

## Run unit tests with code coverage
tests-coverage:
	@echo "  $(P) Start unit tests with code coverage"
	@echo
	@$(VENDOR)/bin/phpunit -c $(VENDOR)/typo3/testing-framework/Resources/Core/Build/UnitTests.xml --whitelist $(PWD)/Classes/ --coverage-html .build Tests/Unit

## Watch unit tests and run tests upon changes
tests-watch:
	@echo "  $(P) Start unit tests"
	@while inotifywait -e close_write Tests/Unit/* -e close_write Classes/*; do make tests; done

.PHONY: help clean build tests tests-coverage tests-watch install

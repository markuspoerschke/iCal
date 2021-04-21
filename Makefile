-include Makefile.local

export XDEBUG_MODE=coverage

MAKEFLAGS += --warn-undefined-variables
SHELL := bash
PATH := $(CURDIR)/vendor/bin:$(PATH)
PSALM_FLAGS ?=
PHPUNIT_FLAGS ?=
INFECTION_FLAGS ?=

.PHONY: help
help:
	@echo 'Available targets'
	@echo '  clean               Removes temporary build artifacts like'
	@echo '  dependencies        Installs composer dependencies'
	@echo '  docs                Builds the documentation website'
	@echo '  fix                 Fixes composer.json and code style'
	@echo '  fix-prettier        Fix code style of non PHP files (not included in "fix" target)'
	@echo '  test                Execute all tests'

.PHONY: test
test: test-validate-composer test-code-style test-psalm test-phpunit test-examples test-composer-normalize test-phpmd test-infection

.PHONY: test-code-style
test-code-style: dependencies
	php-cs-fixer fix --dry-run --diff

.PHONY: test-psalm
test-psalm: dependencies
	psalm -m --no-progress ${PSALM_FLAGS}

.PHONY: test-phpunit
test-phpunit: dependencies
	phpunit --coverage-xml=build/coverage/coverage-xml --log-junit=build/coverage/junit.xml ${PHPUNIT_FLAGS}

.PHONY: test-examples
EXAMPLE_FILES := $(wildcard examples/*.php)
test-examples: $(EXAMPLE_FILES)

.PHONY: test-infection
test-infection: dependencies test-phpunit
test-infection:
	infection --min-msi=60 --coverage=build/coverage ${INFECTION_FLAGS}

examples/example*.php: dependencies
	php $@ > /dev/null

.PHONY: test-validate-composer
test-validate-composer:
	composer validate

.PHONY: test-composer-normalize
test-composer-normalize: dependencies
test-composer-normalize:
	composer normalize --dry-run --diff

.PHONY: test-phpmd
test-phpmd: dependencies
test-phpmd:
	phpmd ./src text rulesets.xml

.PHONY: test-prettier
test-prettier:
	yarn
	npx prettier --check .

.PHONY: dependencies
dependencies:
	composer install --no-interaction

.PHONY: fix
fix: fix-code-style fix-composer

.PHONY: fix-code-style
fix-code-style: dependencies
fix-code-style:
	php-cs-fixer -- fix

.PHONY: fix-composer
fix-composer: dependencies
fix-composer:
	composer normalize --no-update-lock
	composer update nothing

.PHONY: fix-prettier
fix-prettier:
	yarn
	npx prettier --write .

.PHONY: docs
docs: docs-dependencies
	cd  website && yarn build

.PHONY: docs-dependencies
docs-dependencies:
	cd website && yarn

.PHONY: docs-preview
docs-preview: docs-dependencies
	cd website && yarn start

.PHONY: clean
clean:
	rm -rf vendor website/node_modules website/build website/.docusaurus node_modules .phpunit.result.cache .php_cs.cache build

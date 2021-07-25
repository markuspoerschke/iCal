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
	@echo '  docs                Builds the documentation website'
	@echo '  fix                 Fixes composer.json and code style'
	@echo '  fix-prettier        Fix code style of non PHP files (not included in "fix" target)'
	@echo '  test                Execute all tests'
	@echo '  vendor              Installs composer vendor'

.PHONY: test
test: test-validate-composer test-code-style test-psalm test-phpunit test-examples test-composer-normalize test-phpmd test-infection

.PHONY: test-code-style
test-code-style: vendor
	php-cs-fixer fix --dry-run --diff

.PHONY: test-psalm
test-psalm: vendor
	psalm -m --no-progress ${PSALM_FLAGS}

.PHONY: test-phpunit
test-phpunit: vendor
	phpunit --coverage-xml=build/coverage/coverage-xml --log-junit=build/coverage/junit.xml ${PHPUNIT_FLAGS}

.PHONY: test-examples
EXAMPLE_FILES := $(wildcard examples/*.php)
test-examples: $(EXAMPLE_FILES)

.PHONY: test-infection
test-infection: vendor test-phpunit
test-infection:
	infection --min-msi=60 --coverage=build/coverage ${INFECTION_FLAGS}

examples/example*.php: vendor
	php $@ > /dev/null

.PHONY: test-validate-composer
test-validate-composer:
	composer validate

.PHONY: test-composer-normalize
test-composer-normalize: vendor
test-composer-normalize:
	composer normalize --dry-run --diff

.PHONY: test-phpmd
test-phpmd: vendor
test-phpmd:
	phpmd ./src text rulesets.xml

.PHONY: test-prettier
test-prettier:
	yarn
	npx prettier --check .

vendor: composer.json composer.lock
	composer install --no-interaction

.PHONY: fix
fix: fix-code-style fix-composer

.PHONY: fix-code-style
fix-code-style: vendor
fix-code-style:
	php-cs-fixer -- fix

.PHONY: fix-composer
fix-composer: vendor
fix-composer:
	composer normalize --no-update-lock
	composer update nothing

.PHONY: fix-prettier
fix-prettier: node_modules
	npx prettier --write .

node_modules: yarn.lock package.json
	yarn

.PHONY: docs
docs: docs-vendor
	cd  website && yarn build

.PHONY: docs-vendor
docs-vendor:
	cd website && yarn

.PHONY: docs-preview
docs-preview: docs-vendor
	cd website && yarn start

.PHONY: clean
clean:
	rm -rf vendor website/node_modules website/build website/.docusaurus node_modules .phpunit.result.cache .php-cs-fixer.cache build

MAKEFLAGS += --warn-undefined-variables
SHELL := bash
PATH := $(PATH):$(CURDIR)/vendor/bin
PSALM_FLAGS ?=
PHPUNIT_FLAGS ?=

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
	which phpunit
	phpunit ${PHPUNIT_FLAGS}

.PHONY: test-examples
EXAMPLE_FILES := $(wildcard examples/*.php)
test-examples: $(EXAMPLE_FILES)

.PHONY: test-infection
test-infection: dependencies test-phpunit
test-infection:
	infection --min-msi=60

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
docs: docs-dependencies docs-frontend-build
	php couscous.phar generate

.PHONY: docs-dependencies
docs-dependencies:
	if [ ! -f couscous.phar ]; then php -r "copy('https://github.com/CouscousPHP/Couscous/releases/download/1.8.0/couscous.phar', 'couscous.phar');"; fi

.PHONY: docs-preview
docs-preview: docs-dependencies docs-frontend-build
	php couscous.phar preview

.PHONY: docs-frontend-dependencies
docs-frontend-dependencies:
	cd website && yarn

.PHONY: docs-frontend-build
docs-frontend-build: docs-frontend-dependencies
	cd  website && yarn build

.PHONY: clean
clean:
	rm -rf vendor composer.lock .couscous website/node_modules website/template/static couscous.phar node_modules .phpunit.result.cache .php_cs.cache report

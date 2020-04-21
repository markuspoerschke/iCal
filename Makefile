MAKE_COMPOSER_EXEC := composer exec -v

.PHONY: test
test: test-validate-composer test-code-style test-psalm test-phpunit test-composer-normalize

.PHONY: test-code-style
test-code-style: dependencies
	${MAKE_COMPOSER_EXEC} php-cs-fixer -- fix --dry-run --diff

.PHONY: test-psalm
test-psalm: dependencies
	${MAKE_COMPOSER_EXEC} psalm -- -m --no-progress

.PHONY: test-phpunit
test-phpunit: dependencies
	${MAKE_COMPOSER_EXEC} phpunit -- ${PHPUNIT_FLAGS}

.PHONY: test-validate-composer
test-validate-composer:
	composer validate

.PHONY: test-composer-normalize
test-composer-normalize: dependencies
test-composer-normalize:
	composer normalize --dry-run --diff

.PHONY: dependencies
dependencies:
	composer install --no-interaction

.PHONY: fix
fix: fix-code-style fix-composer

.PHONY: fix-code-style
fix-code-style: dependencies
fix-code-style:
	${MAKE_COMPOSER_EXEC} php-cs-fixer -- fix

.PHONY: fix-composer
fix-composer: dependencies
fix-composer:
	composer normalize --no-update-lock

.PHONY: docs
docs: docs-dependencies docs-frontend-build
	php couscous.phar generate

.PHONY: docs-dependencies
docs-dependencies:
	if [ ! -f couscous.phar ]; then php -r "copy('https://github.com/CouscousPHP/Couscous/releases/download/1.7.3/couscous.phar', 'couscous.phar');"; fi

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
	rm -rf vendor composer.lock .couscous website/node_modules website/template/static couscous.phar

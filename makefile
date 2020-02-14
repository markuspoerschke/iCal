test: dependencies
	composer test

dependencies:
	composer install --no-interaction

fix-code-style: dependencies
	composer fix:code-style

docs-dependencies:
	if [ ! -f couscous.phar ]; then php -r "copy('https://github.com/CouscousPHP/Couscous/releases/download/1.7.3/couscous.phar', 'couscous.phar');"; fi

docs-preview: docs-dependencies docs-frontend-build
	php couscous.phar preview

docs-frontend-dependencies:
	cd website && yarn

docs-frontend-build: docs-frontend-dependencies
	cd  website && yarn build

.PHONY: test dependencies fix-code-style docs-dependencies docs-preview docs-frontend-dependencies docs-frontend-build

build: node_modules docs/** src/** static/** docusaurus.config.js sidebars.js
	yarn build

node_modules: ../yarn.lock package.json
	yarn

.PHONY: start
start: node_modules
	yarn start

.PHONY: clean
clean:
	rm -rf node_modules build .docusaurus

# Executables
COMPOSER = $(PHP_CONT) composer

# Misc
.DEFAULT_GOAL = help
.PHONY        = help build up start down logs sh composer vendor sf cc

## —— 🎵 🐳 The Symfony Docker Makefile 🐳 🎵 ——————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙 ——————————————————————————————————————————————————————————————
composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

## —— Tests 🧪 —————————————————————————————————————————————————————————————————
test: test-phpunit test-static ## Run all tests (PHPUnit, Psalm)

test-phpunit: ## Run all PhpSpec tests
	@$(COMPOSER) test

test-static: ## Find errors in your code without actually running it. It catches whole classes of bugs even before you write tests for the code.
	@$(PHP_CONT) vendor/bin/psalm --no-cache $(if $(ARGS),$(ARGS),) $(VERBOSECMD)

test-phpcs: ## Show PHPCS errors
	docker run --rm -v $(PWD):/data cytopia/php-cs-fixer:latest-0.9 fix --dry-run --diff --config=.php-cs-fixer.dist.php --using-cache=no

ci: ## Continuous integration commands
	test-phpunit
	test-static
	test-phpcs

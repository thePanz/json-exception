SRC_DIR="src/"
SRC_FILES= $(shell find $(SRC_DIR) -name "*.php")

tools/phpunit:
	wget --directory-prefix=tools --quiet https://phar.phpunit.de/phpunit-8.phar
	mv tools/phpunit-8.phar tools/phpunit
	chmod +x tools/phpunit

tools/php-cs-fixer:
	wget --directory-prefix=tools --quiet https://github.com/FriendsOfPHP/PHP-CS-Fixer/releases/download/v3.0.2/php-cs-fixer.phar
	mv tools/php-cs-fixer.phar tools/php-cs-fixer
	chmod +x tools/php-cs-fixer

tools/phpstan:
	wget --output-document=tools/phpstan --quiet https://github.com/phpstan/phpstan/releases/download/0.12.94/phpstan.phar
	chmod +x tools/phpstan

tests: tools/phpunit
	composer install --optimize-autoloader --no-suggest --quiet --prefer-dist
	tools/phpunit

phpcs: tools/php-cs-fixer tools/phpstan
	composer install --optimize-autoloader --no-dev --no-suggest --quiet --prefer-dist
	tools/php-cs-fixer fix --dry-run --stop-on-violation -v
	tools/phpstan analyze --level=8 --no-progress src/

fix-cs: tools/php-cs-fixer
	tools/php-cs-fixer fix -v

clean:
	rm tools/ vendor/ -fr

.PHONY: clean phpcs fix-cs tests

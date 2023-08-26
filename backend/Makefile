# Setup command will setup entire backend for project
setup:
	@make install
	@make up
	@make setup_db

# install composer dependencies
install:
	composer install

# build and up docker container through Laravel Sail
up:
	./vendor/bin/sail up -d

# Stop Laravel Sail
stop:
	./vendor/bin/sail stop

# Run Tests
test:
	./vendor/bin/sail test

# Setup mySQL db by migrating fresh and seeding db with dummy data for testing.
setup_db:
	./vendor/bin/sail artisan migrate:fresh
	./vendor/bin/sail artisan db:seed
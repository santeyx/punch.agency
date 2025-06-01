## Install

sudo nano .env

APP_KEY=
APP_URL=https://localhost.test
APP_DOMAIN=localhost.test
APP_TELEGRAM_TOKEN=
QUEUE_CONNECTION=database

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

sudo chmod -R 777 storage
composer install
php artisan key:generate
php artisan queue:table
php artisan migrate

## Commands
https://localhost.test/setwebhook //Set webhook for Telegram

php artisan tasks:notify //Get all tasks for notify
php artisan queue:work //Start queue worker


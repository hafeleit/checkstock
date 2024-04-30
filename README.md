git clone
composer install
compy .env.example .env
php artisan key:generate
php artisan migrate
APP_URL=http://127.0.0.1:8000

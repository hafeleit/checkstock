git clone
composer install
compy .env.example .env
php artisan key:generate
php artisan migrate
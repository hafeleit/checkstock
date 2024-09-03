1. git clone https://github.com/hafeleit/checkstock.git
2. composer update --ignore-platform-req=ext-gd
3. copy .env.example .env
4. php artisan key:generate
5. php artisan migrate
6. APP_URL=http://127.0.0.1:8000
7. git push by command line first

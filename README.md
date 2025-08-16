1. git clone https://github.com/hafeleit/checkstock.git
2. composer update --ignore-platform-req=ext-gd
3. copy .env.example .env
4. php artisan key:generate
5. php artisan migrate
6. APP_URL=http://127.0.0.1:8000
7. git push by command line first
8. php artisan db:seed --class="UserRolePermissionSeeder"

-----

### external database setup

to connect to an external database, add the following to your **.env** file:

```
external_db_connection=your_database_connection
external_db_host=your_database_host
external_db_port=your_database_port
external_db_database=your_database_name
external_db_username=your_username
external_db_password=your_password
```
### migrating the database

to run migrations on the external database, use this command:

```
php artisan migrate --database=external_mysql --path=database/migrations/external
```
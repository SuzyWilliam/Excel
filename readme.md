
## Install Project

- create database with name "hug_assign"
- open .env file (if not exist cope .env.example and rename to .env )and fill the below line with your own configuration 
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=assign
    DB_USERNAME= (your root name)
    DB_PASSWORD= (your root password)

- on folder directory open terminal and run the below lines
    - composer install
    - php artisan migrate
    - php artisan serve

- for csv file example you will find it in (storage\app\users.csv)

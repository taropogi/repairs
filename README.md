## About Repairs

This is a website created by Richard Bernisca.

## How to deploy

-   Clone the repositoy .
-   Run "composer install"
-   Run "npm install"
-   Create an .env file from .env.example. If you are on linux, run `cp .env.example .env` command to create .env file.
-   Run "php artisan key:generate" to create an app key appended to .env file.

## To remove the /public in url

-   If you are using linux you have to set `AllowOverride All` in httpd.conf to honor the .htaccess config in your project's root directory. Httpd.conf is usually located at /etc/httpd/conf/httpd.conf.

## laravel.log could not be opened?

-   If you are receive this error, probably you are running in linux. Try to run `chmod -R 777 storage`;

## Stack

-   Laravel
-   Vue
-   Mysql

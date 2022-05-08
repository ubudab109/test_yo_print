## Requirements

- PHP 8.0 >
- Linux Operating System (Prefered Ubuntu 20)
- Apache
- MySQL
- NPM 8.8.0+ and Node 18.1.0+
- Horizon
- Redis


## Setup

- Setup .env from .env.example
- Run `composer install`
- Run `npm install`
- Run `php artisan ui vue`
- Run `php artisan migrate` to migrate all table
- Run `php artisan key:generate` to generate new app key
- Run `php artisan optimize:clear` clear all cache 
- Run `php artisan horizon`
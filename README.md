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


## UI
![Screenshot from 2022-05-08 17-11-27](https://user-images.githubusercontent.com/62287144/167291566-b00e29c0-aa36-45a0-a16a-b3bf5b0793e2.png)

# Athena-web-service
Lightweight REST service emulator for Korean Ragnarok Online client

## Prerequisites
* PHP >= 7.2
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
This project runs on any web server with PHP support.

## Installation
To install dependencies for this project, you need [https://getcomposer.org/](Composer).  
* run `composer install` to install dependencies.  
* copy `.env.example` and paste it as `.env`.
* edit `.env` and add your MySQL credentials.
* run `php artisan key:generate` to generate the encryption key for your installation.
* run `php artisan migrate` to create required MySQL tables.
* see `config` directory for additional configurations.

## Support
Discord: https://discord.gg/u5N69Dy
Please do not open an issue to ask for support here, and please do not DM me!

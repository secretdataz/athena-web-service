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
* edit `.env`  
    * add your MySQL credentials.  
    * change `ATHENA_ALLOWED_WORLDS` value to your character server  name  
* run `php artisan key:generate` to generate the encryption key for your installation.
* run `php artisan migrate` to create required MySQL tables.
* see `config` directory for additional configurations.

## Support & Troubleshooting
Error logs can be viewed in `storage/logs` directory
Discord: https://discord.gg/u5N69Dy  
Please do not open an issue to ask for support here, and please do not DM me!

## Donate
If you use this project for your server and would like to thank me, [buy me a coffee](https://ko-fi.com/secretdz)  
Bitcoin: 1DAfsJDkMYoN5Dt1zSQPDTGeMTrFuFYQH5  
Bitcoin Cash: qzzhtv4qyx4e6hfv0cpyqemh0xnhplpgeyqv0wyes7  
Ethereum: 0x78140bD7F15DaEa965d53DA5734b688afC27c292  

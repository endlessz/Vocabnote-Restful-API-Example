# Vocabnote

This is an example Restful API using Lumen 5.3.2

# Features
+ JWT Authentication using [Tymondesigns/ jwt-auth] (https://github.com/tymondesigns/jwt-auth)
+ RESTful routing and errors
+ Models with proper relationships
+ Rate Limit

## Quick Start

- Clone this repo or download it's release archive and extract it somewhere
- You may delete `.git` folder if you get this code via `git clone`
- Run `composer install`
- Run `php artisan jwt:generate`
- Configure your `.env` file for authenticating via database.
- Run `php artisan migrate --seed`
- Run `php -S localhost:8000 -t public/` to start server.

## License

The application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

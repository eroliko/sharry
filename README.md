# Sharry mini project
This is a mini project for Sharry company.

To accomplish the assigment I used Laravel 9 
on [Porto](https://github.com/Mahmoudz/Porto) 
architecture.

## Requirements
- Docker

## Installation
In the project root, run:
- Run `docker-compose build`
- Run `docker-compose up -d`
- Run `cp .env.example .env`

Run `docker-compose exec app bash` in the project root and then
int the opened environment:
- `composer i`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`

## Usage
See routes via `php artisan route:list` command,
they are self-explanatory, and call provided EPs.

To authenticate, use `POST:sanctum/token` route
(provide `email` and `password`).

Seeded users are to find in `users` table, all of them have
password `password`.

## Server
Server was tested on Ubuntu Ubuntu 22.04.1 LTS with Docker version
20.10.18, build b40c2f6.

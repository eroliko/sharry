# Sharry mini project
This is a mini project for Sharry company.

To accomplish the assigment I used Laravel 9

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

## Server
Server was tested on Ubuntu Ubuntu 22.04.1 LTS with Docker version
20.10.18, build b40c2f6.

## Usage
Go to URL `http://sharry.localhost`. MySQL DB is accessible
via URL `http://localhost:3000/` - credentials are in the
`.env.example` file.

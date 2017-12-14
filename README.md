# Installation

`composer install`

Create .env file in the root directory, near .env.dist

In .env file modify DATABASE_URL so that symfony could connect to your database.
Pick a database name, you do not need to have it created.

Run

`php bin/console doctrine:database:create`

this will create database.

Create table:
`php bin/console doctrine:migrations:migrate`
(choose yes answer).


# How to develop on this project ?

This project come as a Symfony app, but with a React.js frontend for some part of the application.

You can run the backend commands in a first console, and the frontend commands in a second console.

## Run the Symfony backend

You need to have `php` and `composer` (https://getcomposer.org) on your computer.

You need to install the needed dependencies :

```
composer install
```

By default you can develop on SQLite db, it comes with no prerequisites. If you
want to test mysql then you have to create a `.env.local` file (do not commit!)
with the following content:

```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

and change db_user db_password db_name with correct values for you.

Then you can init the database:

```
bin/console doctrine:migrations:migrate
```

Populate with fake data *(faker formaters [here](https://github.com/fzaninotto/Faker#formatters))*:

```
bin/console doctrine:fixture:load
```

Then you can start the local webserver and go on `http://localhost:8000` !

```
bin/console server:run
```

## Frontend

You need to have `yarn` on your computer.

Install dependencies:

```
yarn install
```

Run the dev environment that recompile when js files change:

```
yarn encore dev --watch
```

### Translations

This project is using the translation module of Symfony
([doc here](https://symfony.com/doc/current/translation.html)).
The template is written in english and we want to have a french
 translation.

## Modify data model

You can just modify `src/Entity/*` classes to edit the data model and links. Symfony
provide a tool named `doctrine:schema:update` but we prefer on this project to use
`doctrine:migrations:migrate` (it is [safer](https://symfony.com/doc/current/doctrine.html#migrations-creating-the-database-tables-schema))

After your modification create your migration file:

```
bin/console make:migration
```

It will make the migration file.

Then apply the migration files on your database:

```
bin/console doctrine:migrations:migrate
```

## Test

Run:

```
bin/phpunit
```

A CI test build is launched automatically by Travis-CI at each commit.

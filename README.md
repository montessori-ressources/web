# Montessori-Ressources web app

[![Build Status](https://travis-ci.org/montessori-ressources/web.svg?branch=master)](https://travis-ci.org/montessori-ressources/web)

This is the git repository of the Montessori Ressources webapp. It is a Symfony
webapp designed to help Montessori community finding the right tool.

## How to develop on this project ?

If you want to help **PR** and [issues](https://github.com/montessori-ressources/web/issues) are welcome !

You need to have `php` and `composer` (https://getcomposer.org) on your computer.

First you need to install the needed dependencies :

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
bin/console doctrine:schema:create
```

Populate with fake data *(faker formaters [here](https://github.com/fzaninotto/Faker#formatters))*:

```
bin/console doctrine:fixture:load
```

Then you can start the local webserver and go on `http://localhost:8000` !

```
bin/console server:run
```

## Test

Run:

```
bin/phpunit
```

A CI test build is launched automatically by Travis-CI at each commit.

## Deploy

A preferred way to deploy the application is via a docker-like engine (Heroku,
  Dokku, etc...).

TODO

## Licence

This project is licensed under the MIT License - see the LICENSE.md file for details

## Thanks

TODO

# Montessori-Ressources web app

[![Build Status](https://travis-ci.org/montessori-ressources/web.svg?branch=master)](https://travis-ci.org/montessori-ressources/web)

This is the git repository of the Montessori Ressources webapp. It is a Symfony
webapp designed to help Montessori community finding the right tool.

## How to develop on this project ?

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

and change db_user db_password db_name with corect values for you.

Then you can init the database (SQlite by default to avoid a MySQL database running
  on local)

```
bin/console doctrine:schema:create
```



Then you can populate with fake data:

```
bin/console doctrine:fixture:load
```

Faker formaters : https://github.com/fzaninotto/Faker#formatters

## Test

Run:

```
bin/phpunit
```

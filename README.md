# Montessori-Ressources web app

This is the git repository of the Montessori Ressources webapp. It is a Symfony
webapp designed to help Montessori community finding the right tool.

## How to develop on this project ?

You need to have `php` and `composer` (https://getcomposer.org) on your computer.

First you need to install the needed dependencies :

```
composer install
```

Then you can init the database (SQlite by default to avoid a MySQL database running
  on local)

```
bin/console doctrine:schema:create
```

Then you can populate with fake data:

```
bin/console doctrine:fixture:load
```

## Test

Run:

```
bin/phpunit
```

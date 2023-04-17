# Fruits Test Application

A symfony application with vue frontend.

## Setup

### Install dependencies

Install/build php packages, and javascript packages. Finally build javascript

```
composer install
yarn install --force
yarn build
```

### Create database and load data from fruits api

```
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force --complete
php bin/console fruits:fetch
```

## Start Symfony server

```
symfony serve
```

Vist browser to view application

Create test database and schema and load fixtures

## Testing

```
php bin/console --env=test doctrine:database:create
php bin/console --env=test doctrine:schema:create
php bin/console --env=test doctrine:fixtures:load
```

Run the Tests

```
php bin/phpunit
```

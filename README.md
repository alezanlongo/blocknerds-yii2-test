# Bootstrapping Exercise 2 - Yii 2.0 Advanced Application Template
https://github.com/alezanlongo/blocknerds-yii2-test/tree/nahuel-blocknerds

## Installing using Composer
sudo docker run --rm -v $(pwd):/app composer create-project --prefer-dist yiisoft/yii2-app-advanced yii-application

### Redis
cd yii-application/
sudo docker run --rm -v $(pwd):/app composer require --prefer-dist yiisoft/yii2-redis
sudo docker run --rm -v $(pwd):/app composer require --prefer-dist igogo5yo/yii2-upload-from-url
sudo docker run --rm -v $(pwd):/app composer require --prefer-dist yiisoft/yii2-httpclient "*"

### Setting permissions
sudo chown ${USER}:${USER} -R yii-application/
sudo chmod 775 -R yii-application/

## Run
sudo docker-compose -f docker-compose.yml up --build

## Preparing application
https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md

### Open a console terminal, execute the init command and select dev as environment.
1. sudo docker exec -it yii2_test_php bash
2. php init

### apply migrations with command 
1. sudo docker exec -it yii2_test_php bash
2. php yii migrate

### Adjust the components['db'] configuration in /path/to/yii-application/common/config/main-local.php
'dsn' => 'pgsql:host=db;dbname=yii2'

### Change the hosts file to point the domain to your server.
Windows: c:\Windows\System32\Drivers\etc\hosts
Linux: /etc/hosts

### Add the following lines:
127.0.0.1   frontend.test
127.0.0.1   backend.test

## Access APP
http://backend.test
http://frontend.test

## MailHog
http://frontend.test:8025

# Docker commands

## Access to container
sudo docker exec -it yii2_test_php bash
sudo docker exec -it yii2_test_pgsql bash

### Access DB
psql --dbname yii2 --username docker

## Stop all containers
docker stop $(docker ps -q)

## delete all images
docker rmi -f $(docker images -a -q)

## Clean
docker system prune  

# Codeception (unit, functional, and acceptance tests)

## Ceate a test
php vendor/bin/codecept generate:test unit Example -c common

## Run one test
./vendor/bin/codecept run common/tests/unit/CollectionTest
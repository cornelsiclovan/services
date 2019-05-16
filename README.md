## services description
# find a service provider in your area

## server settings 
# php 7.2
# mysql ver 15.1  distrib 10.2.16-MariaDB
# composer installed

## installation guide
# clone the project from github or download the zip file
# run for installing libraries 
$composer install
# create database
$./bin/console doctrine:database:create
# migrate migrations
$./bin/console doctrine:migrations:migrate
# load fixtures
$./bin/console doctrine:fixtures:load


#!/bin/bash

php artisan down
git pull
php artisan migrate
php artisan up

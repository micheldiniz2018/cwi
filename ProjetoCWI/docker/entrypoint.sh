#!/bin/sh
set -ex

pkill -9 php-fpm || true
rm -f /var/run/php/php-fpm.sock || true

mkdir -p /var/run/php
chown www-data:www-data /var/run/php

if [ ! -d "vendor" ]; then
    composer install
fi

exec php-fpm -F

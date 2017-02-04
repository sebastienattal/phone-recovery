#!/bin/bash
# Deployment script for prod environment

export SYMFONY_ENV=prod

cp -f web/app.php web/index.php

composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod --no-debug
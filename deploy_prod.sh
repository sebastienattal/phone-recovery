#!/bin/bash
# Deployment script for prod environment

export SYMFONY_ENV=prod

composer install --no-dev --optimize-autoloader
php bin/console cache:clear --env=prod --no-debug
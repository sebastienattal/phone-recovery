#!/bin/bash
# Deployment script for dev environment

cp -f web/app_dev.php web/index.php

composer install
php bin/console cache:clear
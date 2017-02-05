#!/bin/bash
# Deployment script for dev environment

composer install
php bin/console cache:clear
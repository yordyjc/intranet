#!/bin/sh
set -e

echo "Ejecutando composer install/update..."
composer install --no-interaction --prefer-dist

echo "Ejecutando migraciones..."
php artisan migrate --force

# Al final, lanza el proceso principal (de CMD)
exec "$@"

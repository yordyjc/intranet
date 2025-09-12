#!/bin/sh
set -e

echo "Ejecutando composer install/update..."
if ! composer install --no-interaction --prefer-dist; then
  echo "Error en composer install"
  exit 1
fi

echo "Ejecutando migraciones..."
if ! php artisan migrate --force; then
  echo "Error en migraciones"
  exit 1
fi

echo "Entrypoint terminado, lanzando proceso principal..."
exec "$@"
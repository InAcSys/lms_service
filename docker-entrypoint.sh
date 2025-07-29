#!/bin/sh
set -e

until nc -z "$DB_HOST" "$DB_PORT"; do
  echo "La base de datos aún no está disponible..."
  sleep 2
done

# 🔧 Composer install cuando ya hay red
composer install --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-dev || true

# Skip Octane for now to test basic Laravel functionality
# if php artisan --quiet list | grep -q octane; then
#     echo "Laravel Octane ya está instalado."
# else
#     echo "Instalando Laravel Octane..."
#     composer require laravel/octane
#     php artisan octane:install --server="swoole" --no-interaction
# fi

php artisan migrate --force

# Use regular Laravel dev server instead of Octane
exec php artisan serve --host="0.0.0.0" --port="8000"

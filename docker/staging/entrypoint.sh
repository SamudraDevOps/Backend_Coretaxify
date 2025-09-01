#!/bin/sh

set -e

# Change to the application directory
cd /var/www/html

echo "Running Laravel startup tasks..."

php artisan migrate --force

# IMPORTANT: Re-apply ownership to the www-data user
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Startup complete. Handing over to main process..."

# Execute the command passed as arguments to the script (the Dockerfile's CMD)
exec "$@"
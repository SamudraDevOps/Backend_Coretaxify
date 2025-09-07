#!/bin/sh

set -e

# Change to the application directory
cd /var/www/html

echo "Running Laravel startup tasks..."

php artisan optimize
# php artisan migrate --force

echo "Startup complete. Handing over to main process..."

# Execute the command passed as arguments to the script (the Dockerfile's CMD)
exec "$@"
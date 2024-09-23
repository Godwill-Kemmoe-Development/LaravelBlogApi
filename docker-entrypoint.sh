#!/bin/bash

# Set permissions for Laravel (storage, public, and bootstrap cache)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Run the main container command (Apache in this case)
exec "$@"

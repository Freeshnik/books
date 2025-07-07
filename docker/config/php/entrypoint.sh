#!/bin/bash

# Check if the vendor directory exists in the mounted volume
if [ ! -d /var/www/html/vendor ]; then
  echo "Vendor directory not found, running composer install as root..."
  gosu root composer install --optimize-autoloader
fi

# Execute the main command as www-data
exec gosu www-data "$@"
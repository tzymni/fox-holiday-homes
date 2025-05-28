#!/bin/bash
set -e

# Tu możesz dodać migracje, cache itp.

mkdir -p /var/lib/nginx/body
chown -R www-data:www-data /var/lib/nginx

# Na końcu przekazujemy CMD
exec "$@"

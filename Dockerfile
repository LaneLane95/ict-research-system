FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Siguraduhin na /public ang webroot
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# --- ETO ANG MAGIC FIX PARA SA ROUTING ---
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default.conf

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# --- DATABASE SETUP & PERMISSIONS ---
# Gagawa tayo ng folder at empty sqlite file
RUN mkdir -p /var/www/html/database
RUN touch /var/www/html/database/database.sqlite

# Permissions: Siguraduhin na writable ang database at storage
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# --- STARTUP SCRIPT (THE ULTIMATE FIX) ---
# Dito natin ilalagay ang migration na tatakbo pag-on ng server
ENV RUN_SCRIPTS=1
RUN mkdir -p /var/www/html/scripts

# Gagawa tayo ng bash script na magpapatakbo ng migration bago mag-load ang site
RUN echo "#!/bin/bash\n\
php artisan migrate --force\n\
chmod 777 /var/www/html/database/database.sqlite\n\
php artisan config:clear" > /var/www/html/scripts/00-migrate.sh

RUN chmod +x /var/www/html/scripts/00-migrate.sh

RUN php artisan config:clear

CMD ["/start.sh"]
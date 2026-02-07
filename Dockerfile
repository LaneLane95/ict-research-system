FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Siguraduhin na /public ang webroot
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# Fix for routing
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default.conf

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Database setup
RUN mkdir -p /var/www/html/database
RUN touch /var/www/html/database/database.sqlite

# Permissions: Importante para makapag-save
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chown -R www-data:www-data /var/www/html/database

# --- FORCE MIGRATION DURING BUILD ---
# Eto ang pamatay sa "no column is_archived" error
RUN php artisan migrate --force

RUN php artisan config:clear

# Startup settings
ENV RUN_SCRIPTS=1
CMD ["/start.sh"]
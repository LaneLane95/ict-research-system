FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false

# --- ETO ANG MAGIC LINE PARA HINDI MAG-404 SA LOGIN/LOGOUT ---
RUN sed -i 's/try_files $uri $uri\/ =404;/try_files $uri $uri\/ \/index.php?$query_string;/g' /etc/nginx/sites-available/default.conf

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Permissions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN php artisan config:clear
RUN php artisan route:clear

CMD ["/start.sh"]
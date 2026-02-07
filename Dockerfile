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

# Database creation inside the correct folder
RUN mkdir -p /var/www/html/database
RUN touch /var/www/html/database/database.sqlite

# Permissions (Sobrang importante!)
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN php artisan config:clear

CMD ["/start.sh"]
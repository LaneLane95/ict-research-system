FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot pabalik sa /public para malinis ang routing
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# --- ETO ANG MAGIC FIX PARA SA 404/NOT FOUND ---
# Pinupuwersa nito si Nginx na hanapin ang index.php sa loob ng public folder
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default.conf

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Database at Permissions
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN php artisan config:clear

CMD ["/start.sh"]
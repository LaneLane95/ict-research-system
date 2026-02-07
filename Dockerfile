FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot sa public folder
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# 1. INSTALL DEPENDENCIES (Eto yung nawala kaya nag-fail)
RUN composer install --no-dev --ignore-platform-reqs

# 2. Gawa ng database folder at file
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite

# 3. Force permissions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 4. Clear everything (Gagana na 'to kasi may vendor na)
RUN php artisan config:clear

CMD ["/start.sh"]
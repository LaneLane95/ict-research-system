FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot sa public folder
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# 1. Install dependencies
RUN composer install --no-dev --ignore-platform-reqs

# 2. FORCE GENERATE NAMESPACE (Ito ang fix sa error mo!)
RUN composer dump-autoload --optimize

# 3. Gawa ng database folder at file
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite

# 4. Force permissions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 5. Clear everything
RUN php artisan config:clear

CMD ["/start.sh"]
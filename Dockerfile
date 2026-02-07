FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot sa root folder muna para siguradong mabasa ang artisan
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# Install dependencies at ayusin ang autoload
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Database at Permissions
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Ito ang magsasabi sa Nginx na tanggapin ang routes ng Laravel
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public

RUN php artisan config:clear

CMD ["/start.sh"]
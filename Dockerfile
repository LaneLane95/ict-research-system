FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/html
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false
RUN php artisan migrate --force
RUN composer install --no-dev --ignore-platform-reqs
FROM richarvey/nginx-php-fpm:latest
COPY . /var/www/html
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false
RUN composer install --no-dev --ignore-platform-reqs
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear
RUN php artisan migrate --force
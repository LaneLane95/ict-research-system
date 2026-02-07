FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Dito natin ituturo sa main folder mismo
ENV WEBROOT /var/www/html
ENV APP_ENV=production
ENV APP_DEBUG=true

# I-copy ang laman ng public folder sa labas para sigurado
RUN cp -r /var/www/html/public/* /var/www/html/ || true

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Database at Permissions
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

RUN php artisan config:clear

CMD ["/start.sh"]
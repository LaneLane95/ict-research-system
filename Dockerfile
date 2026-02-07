FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Siguraduhin na ang Webroot ay nakaturo sa public folder
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false

# Permissions para hindi mag-500 Error
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN touch /var/www/html/database/database.sqlite
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Clean cache
RUN php artisan config:clear

CMD ["/start.sh"]
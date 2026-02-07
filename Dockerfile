FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Webroot sa public folder
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# Gawa ng database folder at file
RUN mkdir -p /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
RUN touch /var/www/html/database/database.sqlite

# Force permissions sa lahat ng kailangan
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Clear everything
RUN php artisan config:clear
RUN php artisan cache:clear

CMD ["/start.sh"]
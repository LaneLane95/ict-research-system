FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# I-set ang Public folder bilang Webroot
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=false

# Install dependencies at ayusin ang permissions
RUN composer install --no-dev --ignore-platform-reqs
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite
RUN chmod -R 777 /var/www/html/storage /var/www/html/database /var/www/html/bootstrap/cache

# Linisin ang cache para fresh ang setup
RUN php artisan config:clear
RUN php artisan route:clear
RUN php artisan view:clear

# HINDI natin ilalagay dito ang migrate --force para hindi mag-fail ang build.
# Gagawin natin yun via browser later.
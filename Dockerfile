FROM richarvey/nginx-php-fpm:latest

COPY . /var/www/html

# Siguraduhin na /public ang webroot
ENV WEBROOT /var/www/html/public
ENV APP_ENV=production
ENV APP_DEBUG=true

# --- ETO ANG MAGIC FIX PARA SA ROUTING ---
RUN sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default.conf

# Install dependencies
RUN composer install --no-dev --ignore-platform-reqs
RUN composer dump-autoload --optimize

# Database creation inside the correct folder
RUN mkdir -p /var/www/html/database
RUN touch /var/www/html/database/database.sqlite

# Permissions (Sobrang importante para sa SQLite!)
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# --- ETO YUNG DINAGDAG NATIN BESH ---
# Pinipilit natin ang migration habang nagbi-build para sigurado
RUN php artisan migrate --force

RUN php artisan config:clear

# Eto ang trick sa image na 'to: Pwede tayong maglagay ng scripts sa /var/www/html/scripts/
# Pero para mabilis, gagamitin natin ang ENV variable na supported ng richarvey image
ENV RUN_SCRIPTS=1

# Gagawa tayo ng startup script para mag-migrate uli "just in case" pag-start ng container
RUN mkdir -p /var/www/html/scripts
RUN echo "php artisan migrate --force" > /var/www/html/scripts/install.sh
RUN chmod +x /var/www/html/scripts/install.sh

CMD ["/start.sh"]
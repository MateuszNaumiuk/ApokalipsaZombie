# Obraz bazowy dla PHP i Apache
FROM php:7.4-apache

# Instalacja narzędzi systemowych i rozszerzeń PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN docker-php-ext-install pgsql
RUN docker-php-ext-enable pdo_pgsql
RUN echo "extension=pdo_pgsql" >> /usr/local/etc/php/php.ini

# Konfiguracja Apache
RUN a2enmod rewrite

# Pliki aplikacji
COPY ./app /var/www/html

# Plik init.sql
COPY ./apokalipsa.sql /docker-entrypoint-initdb.d/

# Zmień uprawnienia pliku init.sql
RUN chown www-data:www-data /docker-entrypoint-initdb.d/apokalipsa.sql
RUN chmod 755 /docker-entrypoint-initdb.d/apokalipsa.sql

# Porty
EXPOSE 80

# Polecenie startowe
CMD ["apache2-foreground"]

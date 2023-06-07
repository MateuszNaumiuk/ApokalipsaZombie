# Obraz bazowy dla PHP i Apache
FROM php:7.4-apache

# Instalacja narzędzi systemowych i rozszerzeń PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Konfiguracja Apache
RUN a2enmod rewrite

# Pliki aplikacji
COPY ./app /var/www/html

# Porty
EXPOSE 80

# Polecenie startowe
CMD ["apache2-foreground"]
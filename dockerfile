FROM php:8.3-apache

# Installe les extensions nécessaires à Symfony
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Active le mod_rewrite pour Symfony
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]

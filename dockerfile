FROM php:8.2-apache

# Installe les extensions PHP nécessaires pour Symfony
RUN apt-get update && apt-get install -y \
    git unzip zip libicu-dev libonig-dev libzip-dev libpq-dev libxml2-dev \
    && docker-php-ext-install intl pdo pdo_pgsql zip

# Active mod_rewrite d'Apache
RUN a2enmod rewrite

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le code source Symfony dans le conteneur
COPY . /var/www/html/

WORKDIR /var/www/html

RUN composer install --no-dev --optimize-autoloader

# Configure Apache pour Symfony (point d’entrée = /public)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose le port 80 pour l'accès web
EXPOSE 80

# Lancer les migrations (optionnel selon ton besoin)
RUN php bin/console doctrine:migrations:migrate --no-interaction

# Commande d'exécution pour démarrer Apache
CMD ["apache2-foreground"]

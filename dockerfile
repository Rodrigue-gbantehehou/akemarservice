# Étape 1 : base PHP 8.3 avec Apache
FROM php:8.3-apache

# Étape 2 : activer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip curl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Étape 3 : installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 4 : activer mod_rewrite pour Symfony
RUN a2enmod rewrite

# Étape 5 : définir le dossier de travail
WORKDIR /var/www/html

# Étape 6 : copier le projet
COPY . .

# Étape 7 : installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Étape 8 : exposer le port 80
EXPOSE 80

# Étape 9 : config pour Render (Apache avec Symfony)
CMD ["apache2-foreground"]

# Étape 1 : image de base avec PHP 8.3, Composer, et extensions nécessaires
FROM php:8.3-cli

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git unzip zip curl libpq-dev libonig-dev libxml2-dev \
    libzip-dev libicu-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_pgsql intl zip gd

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet dans le conteneur
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Exposer le port utilisé (optionnel si Apache ou autre)
EXPOSE 8000

# Lancer le serveur Symfony
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

FROM php:8.3-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

RUN apt-get install -y libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl


# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Ajouter le projet dans le container
COPY . .

# ⚠️ Marquer le dossier comme safe pour git
RUN git config --global --add safe.directory /var/www/html

# Installer les dépendances PHP
RUN composer install

# Droits d'accès (optionnel)
RUN chown -R www-data:www-data /var/www/html

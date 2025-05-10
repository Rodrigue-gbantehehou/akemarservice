#!/bin/bash

# Vérifie les migrations et démarre Apache
php bin/console doctrine:migrations:migrate --no-interaction
apache2-foreground

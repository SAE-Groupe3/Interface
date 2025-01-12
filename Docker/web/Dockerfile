FROM php:8.1-apache

# Installation de pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Activer le module mod_rewrite
RUN a2enmod rewrite

# Copier le script wait-for-it.sh
COPY ./Docker/web/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Définir le DocumentRoot
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Copier le code de l'application
COPY ./app /var/www/html

# Commande de démarrage
CMD ["apache2-foreground"]

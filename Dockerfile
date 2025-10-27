# Dockerfile
FROM php:8.0-apache
# Instala las extensiones pdo_pgsql para PHP y otras extensiones comun
RUN apt-get update && apt-get install -y --fix-missing \
libpq-dev \
libpng-dev \
libonig-dev \
libxml2-dev \
zip \
unzip \
git \
&& apt-get clean \
&& rm -rf /var/lib/apt/lists/* \
&& docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd
# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Configura el document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# Cambia el document root del servidor Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Habilita el mod_rewrite para Apache
RUN a2enmod rewrite

# Asegura permisos para el directorio web (opcional, según tu host)
RUN mkdir -p ${APACHE_DOCUMENT_ROOT} \
 && chown -R www-data:www-data ${APACHE_DOCUMENT_ROOT}

# Exponer puerto 80 (informativo)
EXPOSE 80

# Comando por defecto (el contenedor arrancará Apache)
CMD ["apache2-foreground"]
# Usa la imagen base de PHP con Apache
FROM php:8.2-apache

RUN a2enmod rewrite

# Instalar la extensión mysqli
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Git
RUN apt-get update && apt-get install -y git

# instalar unzip
RUN apt-get update && apt-get install -y \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los archivos de la aplicación
WORKDIR /var/www/html
COPY . /var/www/html

# Exponer el puerto 80
EXPOSE 80
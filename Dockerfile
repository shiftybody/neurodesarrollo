# Usar la imagen de PHP 5.4 con Apache
FROM php:5.4-apache

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Instalar las extensiones mysqli y pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar el archivo php.ini personalizado
COPY php.ini /usr/local/etc/php/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos de la aplicación
COPY . /var/www/html

# Exponer el puerto 80
EXPOSE 80

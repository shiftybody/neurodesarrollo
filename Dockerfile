# Use the PHP 5.4 image with Apache
FROM php:5.4-apache

RUN a2enmod rewrite

# Install the mysqli and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy application files
WORKDIR /var/www/html
COPY . /var/www/html

# Expose port 80
EXPOSE 80
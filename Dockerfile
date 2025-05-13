FROM php:7.4-apache
# Install extension mysqli dan dependency-nya
RUN docker-php-ext-install mysqli
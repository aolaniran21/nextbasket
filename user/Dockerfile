# Use the official Apache image as base image
FROM php:apache

# Install necessary PHP extensions and other dependencies
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy the application code to the container
COPY . /var/www/html/nextbasket-test

# Set the working directory
WORKDIR /var/www/html/nextbasket-test
# Use the official PHP image as the base image
FROM php:8.2

# Install system dependencies and GD extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libjpeg62-turbo-dev \
    libpng-dev \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www

# Install Laravel dependencies
COPY . /var/www/
RUN composer install

RUN composer dump-autoload

# Expose port 8000 (defined in docker-compose.yml)
EXPOSE 8000

# The CMD is specified in the docker-compose.yml
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

FROM php:8.3-apache

# Install system dependencies and PHP extension required by Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module
RUN a2enmod rewrite

# Configure Apache doc root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Copy the rest of the application code
COPY . .

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies using Composer
COPY composer.json composer.lock ./
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader

# Install Laravel dependencies
RUN composer dump-autoload && composer install --optimize-autoloader --no-dev

# Set permissions for Laravel (storage, public, and bootstrap cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Update php.ini with a custom max_execution_time
RUN echo "max_execution_time = 120" > /usr/local/etc/php/conf.d/custom.ini

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]

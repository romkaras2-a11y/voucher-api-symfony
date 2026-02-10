FROM php:8.1-cli

WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql intl opcache

# Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]


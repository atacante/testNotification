FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    curl \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install

RUN cp .env.example .env

RUN php artisan key:generate

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]


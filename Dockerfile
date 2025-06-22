FROM php:8.3.7-fpm-alpine
RUN apk add --no-cache linux-headers

RUN apk --no-cache upgrade && \
    apk --no-cache add bash git sudo openssh libxml2-dev oniguruma-dev autoconf gcc g++ make npm freetype-dev \
    libjpeg-turbo-dev libpng-dev libzip-dev ssmtp postgresql-dev icu-dev

# PHP: Install php extensions
RUN pecl channel-update pecl.php.net
RUN pecl install pcov swoole
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-configure intl

# Install all PHP extensions in a single layer
RUN docker-php-ext-install \
    mbstring \
    xml \
    pcntl \
    gd \
    zip \
    sockets \
    pdo \
    pdo_pgsql \
    bcmath \
    soap \
    mysqli \
    intl

# Enable all extensions
RUN docker-php-ext-enable \
    mbstring \
    xml \
    gd \
    zip \
    pcov \
    pcntl \
    sockets \
    bcmath \
    pdo \
    pdo_pgsql \
    soap \
    swoole
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

WORKDIR /app
COPY . .

RUN composer install
RUN composer require spiral/roadrunner
COPY .env .env
RUN mkdir -p /app/storage/logs

# Copy and set up the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

CMD ["/usr/local/bin/docker-entrypoint.sh"]
EXPOSE 8000

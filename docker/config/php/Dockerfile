# Для начала указываем исходный образ, он будет использован как основа
FROM php:8.2-fpm

ARG user
ARG uid
ARG tz
ARG php_server_name

RUN ln -snf /usr/share/zoneinfo/$tz /etc/localtime && echo $tz > /etc/timezone

# RUN выполняет идущую за ней команду в контексте нашего образа.
# В данном случае мы установим некоторые зависимости и модули PHP.
# Для установки модулей используем команду docker-php-ext-install.
# На каждый RUN создается новый слой в образе, поэтому рекомендуется объединять команды.
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
		libzip-dev \
		libpq-dev \
		libonig-dev \
        nano \
        libxml2-dev \
        bash-completion\
        unzip\
        gosu\
        && pecl install redis \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip xml soap gd pdo_pgsql \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Ставим Composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## xdebug
#RUN pecl install xdebug
#COPY xdebug.ini /usr/local/etc/php/conf.d
#ENV PHP_IDE_CONFIG 'serverName='$php_server_name

# Set working directory
WORKDIR /var/www/html/books

# Copy existing application directory contents
COPY . /var/www/html/books

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Install PHP dependencies
#RUN composer install --optimize-autoloader

# Create runtime directories
RUN mkdir -p runtime web/assets \
    && chown -R www-data:www-data runtime web/assets \
    && chmod -R 775 runtime web/assets


# Change current user to www
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

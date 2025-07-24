FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN echo '[global]' > /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'error_log = /proc/self/fd/2' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo '[www]' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen = 9000' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen.owner = www-data' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen.group = www-data' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm = dynamic' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_children = 50' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.start_servers = 5' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.min_spare_servers = 5' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_spare_servers = 10' >> /usr/local/etc/php-fpm.d/zz-docker.conf

COPY docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git wget curl zip unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql mbstring zip exif pcntl bcmath gd sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN wget -O /usr/local/bin/symfony https://github.com/symfony/cli/releases/latest/download/symfony_linux_amd64 \
    && chmod +x /usr/local/bin/symfony

WORKDIR /var/www/backend

ARG UID
ARG GID
ARG USERNAME
ARG GROUP_NAME


RUN groupadd -g $GID $GROUP_NAME \
    && useradd -m -u $UID -g $GID -s /bin/bash $USERNAME \
    && usermod -aG www-data $USERNAME

USER $USERNAME


CMD ["sh", "-c", "composer install --no-interaction --optimize-autoloader && symfony server:start --no-tls --allow-http --port=9000 --address=0.0.0.0"]

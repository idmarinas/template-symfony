FROM dunglas/frankenphp:builder-php8.4-alpine AS builder

# Copy xcaddy in the builder image
COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

# CGO must be enabled to build FrankenPHP
RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS=$'-ldflags "-w -s -extldflags \'-Wl,-z,stack-size=0x80000\'"' \
    CGO_CFLAGS=$(php-config --includes) \
    CGO_LDFLAGS="$(php-config --ldflags) $(php-config --libs)" \
    xcaddy build \
        --output /usr/local/bin/frankenphp \
        --with github.com/dunglas/frankenphp=./ \
        --with github.com/dunglas/frankenphp/caddy=./caddy/ \
        --with github.com/dunglas/caddy-cbrotli \
        # Mercure and Vulcain are included in the official build, but feel free to remove them \
#        --with github.com/dunglas/mercure/caddy \
#        --with github.com/dunglas/vulcain/caddy \
        # Add extra Caddy modules here \
        --with github.com/caddy-dns/cloudflare

FROM dunglas/frankenphp:1-php8.4-alpine AS base

# Replace the official binary by the one contained your custom modules
COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

LABEL authors="IDMarinas"

# Update packages
RUN apk update && apk upgrade --no-self-upgrade --no-cache --no-interactive && rm -rf /var/cache/apk/*

RUN install-php-extensions \
    @composer \
    bcmath \
    exif \
    gd \
    intl \
    pdo_mysql \
    sysvsem \
    zip \
    zstd

###> recipes ###
###< recipes ###

# Caddy config files
COPY --link ./.docker/caddy/sites /etc/frankenphp/sites
COPY --link ./.docker/caddy/snippets/sites.caddyfile /etc/frankenphp/snippets/sites.caddyfile

# PHP config files
COPY --link ./.docker/php/conf.d/00_php.ini /usr/local/etc/php/conf.d/00_php.ini
COPY --link ./.docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/00_opcache.ini
COPY --link ./.docker/php/conf.d/date_timezone.ini /usr/local/etc/php/conf.d/00_date_timezone.ini
COPY --link ./.docker/php/conf.d/disable_functions.ini /usr/local/etc/php/conf.d/00_disable_functions.ini

COPY --link --chmod=755 ./.docker/scripts/run_secrets.sh /usr/local/bin/run_secrets.sh

CMD ["/usr/local/bin/run_secrets.sh"]

###
# Development Image
###

FROM base AS dev

WORKDIR /app

RUN install-php-extensions xdebug

# Caddy config files
COPY --link ./.docker/caddy/main_dev.caddyfile /etc/frankenphp/Caddyfile

# PHP config files
RUN mv "${PHP_INI_DIR}/php.ini-development" "${PHP_INI_DIR}/php.ini"
COPY --link ./.docker/php/conf.d/dev/opcache.ini /usr/local/etc/php/conf.d/01_opcache.ini
COPY --link ./.docker/php/conf.d/dev/php.ini /usr/local/etc/php/conf.d/01_php.ini

RUN apk add --no-cache \
    bash \
    git \
    && git config --global --add safe.directory /app \
    && git config --global core.eol lf \
    && git config --global core.autocrlf input \
    && echo 'alias sf="php bin/console"' >> /etc/bash/bashrc \
    && echo 'alias symfony="php bin/console"' >> /etc/bash/bashrc

###
# Production Image
###

FROM base AS prod

WORKDIR /app

# Caddy config files
COPY --link ./.docker/caddy/main_prod.caddyfile /etc/frankenphp/Caddyfile

# PHP config files
RUN mv "${PHP_INI_DIR}/php.ini-production" "${PHP_INI_DIR}/php.ini"
COPY --link ./.docker/php/conf.d/prod/jit.ini /usr/local/etc/php/conf.d/01_jit.ini
COPY --link ./.docker/php/conf.d/prod/php.ini /usr/local/etc/php/conf.d/01_php.ini

# Symfony Messenger Workers
COPY --link --chmod=755 ./.docker/scripts/entrypoints/worker_async.sh /usr/local/bin/worker_async_entrypoint.sh
COPY --link --chmod=755 ./.docker/scripts/entrypoints/worker_scheduler.sh /usr/local/bin/worker_scheduler_entrypoint.sh

# Sources
COPY --link ./ /app

# Instalar "vendors"
RUN composer install --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --no-scripts

ENV APP_ENV=prod

RUN php bin/console cache:clear \
    && php bin/console tailwind:build assets/styles/app/app.css --minify \
    && php bin/console tailwind:build assets/styles/exception_error.css --minify \
    && php bin/console importmap:install \
    && php bin/console asset-map:compile \
    && php bin/console error:dump var/cache/error_pages/ -f \
    && composer prod:dump:env

RUN chmod 440 .env.local.php .env.docker \
    && rm -f .env .env.dev .env.prod

RUN rm -rf .docker/
RUN rm -rf config/secrets/

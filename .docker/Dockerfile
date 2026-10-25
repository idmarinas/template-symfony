# The different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/build/building/multi-stage/#stop-at-a-specific-build-stage
# https://docs.docker.com/reference/compose-file/build/#target

# Runtime packages needed by the app in both the dev and prod images.
# Add shared media/runtime tooling here so both stages stay in sync.
ARG NEED_PACKAGES_FOR_BUNDLES="libimage-exiftool-perl"

FROM dunglas/frankenphp:1-builder-php8.5-trixie AS builder

# Copy xcaddy in the builder image
COPY --from=caddy:builder /usr/bin/xcaddy /usr/bin/xcaddy

# CGO must be enabled to build FrankenPHP
RUN CGO_ENABLED=1 \
    XCADDY_SETCAP=1 \
    XCADDY_GO_BUILD_FLAGS="-ldflags='-w -s' -tags=nobadger,nomysql,nopgx,deprecated_topic,deprecated_claim" \
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

# Update packages
RUN <<-'EOF'
  apt-get update
  apt-get upgrade -y
  apt-get autoremove
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

FROM dunglas/frankenphp:1-php8.5-trixie AS base

ARG NEED_PACKAGES_FOR_BUNDLES

SHELL ["/bin/bash", "-euxo", "pipefail", "-c"]

# Replace the official binary by the one contained your custom modules
COPY --from=builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp

WORKDIR /app

# persistent deps
RUN <<-EOF
	apt-get update
	apt-get install -y --no-install-recommends file git ${NEED_PACKAGES_FOR_BUNDLES}
	install-php-extensions \
		@composer \
		bcmath \
		exif \
		gd \
		imagick \
		intl \
		pdo_mysql \
		sysvsem \
		xsl \
		zip \
		zstd
	rm -rf /var/lib/apt/lists/*
EOF

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1

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

ARG USER=nonroot

ENV APP_ENV=dev
ENV XDEBUG_MODE=off
ENV FRANKENPHP_WORKER_CONFIG=watch

# Caddy config files
COPY --link ./.docker/caddy/main_dev.caddyfile /etc/frankenphp/Caddyfile

# PHP config files
COPY --link ./.docker/php/conf.d/dev/opcache.ini /usr/local/etc/php/conf.d/01_opcache.ini
COPY --link ./.docker/php/conf.d/dev/php.ini /usr/local/etc/php/conf.d/01_php.ini

# dev dependencies
RUN <<-EOF
	useradd -m -s /bin/bash ${USER}
	# Add additional capability to bind to port 80 and 443
	setcap CAP_NET_BIND_SERVICE=+eip /usr/local/bin/frankenphp
	# Give write access to /config/caddy and /data/caddy
	mkdir -p /data/caddy /config/caddy
  chown -R ${USER}:${USER} /data /config
	mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
	install-php-extensions xdebug
	git config --system --add safe.directory /app
	git config --system core.eol lf
  USER_HOME="$(getent passwd "${USER}" | cut -d: -f6)"
  mkdir -p "${USER_HOME}"
  touch "${USER_HOME}/.bashrc"
  echo 'alias sf="php bin/console"' >> "${USER_HOME}/.bashrc"
  echo 'alias symfony="php bin/console"' >> "${USER_HOME}/.bashrc"
  chown "${USER}:${USER}" "${USER_HOME}/.bashrc"
EOF

USER ${USER}

###
# Builder Production Image
###

FROM base AS prod_builder

SHELL ["/bin/bash", "-euxo", "pipefail", "-c"]

ENV APP_ENV=prod

# Caddy config files
COPY --link ./.docker/caddy/main_prod.caddyfile /etc/frankenphp/Caddyfile

# PHP config files
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --link ./.docker/php/conf.d/prod/jit.ini /usr/local/etc/php/conf.d/01_jit.ini
COPY --link ./.docker/php/conf.d/prod/php.ini /usr/local/etc/php/conf.d/01_php.ini

# Symfony Messenger Workers
COPY --link --chmod=755 ./.docker/scripts/entrypoints/worker_async.sh /usr/local/bin/worker_async_entrypoint.sh
COPY --link --chmod=755 ./.docker/scripts/entrypoints/worker_scheduler.sh /usr/local/bin/worker_scheduler_entrypoint.sh

# Sources
COPY --link ./ /app

# Build the app: install vendors, warm the cache, compile assets, dump the env
RUN <<-EOF
  composer install --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader --classmap-authoritative --no-scripts --no-cache
  composer auto-scripts
  composer tailwind:build -- --minify
  php bin/console importmap:install
  php bin/console asset-map:compile
  php bin/console error:dump var/cache/error_pages/ -f
  composer prod:dump:env
  chmod 440 .env.local.php .env.docker
	chmod +x bin/console
  rm -f .env .env.dev .env.prod .env.prod.local .GHCR_PAT .DHL_PAT
  rm -rf .docker config/secrets/
  # Borrar el ejecutable de Tailwind
  find var/tailwind -name 'v*' -type d -exec /bin/rm -rf {} +
	install -d "var/share/${APP_ENV}/scheduler"
	sync
EOF

# Collect shared libraries needed by FrankenPHP and PHP extensions
RUN <<-'EOF'
	apt-get update
	apt-get install -y --no-install-recommends libtree
	mkdir -p /tmp/libs
	BINARIES=(frankenphp php file)
	for target in $(printf '%s\n' "${BINARIES[@]}" | xargs -I{} which {}) \
		$(find "$(php -r 'echo ini_get("extension_dir");')" -maxdepth 2 -name "*.so"); do
		libtree -pv "$target" 2>/dev/null | grep -oP '(?:── )\K/\S+(?= \[)' | while IFS= read -r lib; do
			[ -f "$lib" ] && cp -n "$lib" /tmp/libs/
		done
	done
	rm -rf /var/lib/apt/lists/*
EOF

###
# Minimal production image (distroless-style)
###
FROM debian:13-slim AS prod
#FROM dhi.io/debian-base:trixie AS prod

ARG NEED_PACKAGES_FOR_BUNDLES

LABEL authors="IDMarinas"

ENV APP_ENV=prod
ENV XDG_CONFIG_HOME=/config XDG_DATA_HOME=/data OPENSSL_CONF=/etc/ssl/openssl.cnf SSL_CERT_FILE=/etc/ssl/certs/ca-certificates.crt
RUN <<-'EOF'
  apt-get update
  apt-get install -y --no-install-recommends ${NEED_PACKAGES_FOR_BUNDLES}
  apt-get upgrade
  apt-get clean
  rm -rf /var/lib/apt/lists/*
EOF

# FrankenPHP binary (custom build with the Cloudflare DNS module) and the PHP runtime
COPY --from=prod_builder /usr/local/bin/frankenphp /usr/local/bin/frankenphp
COPY --from=prod_builder /usr/local/bin/php /usr/local/bin/php
COPY --from=prod_builder /usr/local/bin/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint
COPY --from=prod_builder /usr/local/bin/run_secrets.sh /usr/local/bin/run_secrets.sh
COPY --from=prod_builder /usr/local/bin/worker_async_entrypoint.sh /usr/local/bin/worker_async_entrypoint.sh
COPY --from=prod_builder /usr/local/bin/worker_scheduler_entrypoint.sh /usr/local/bin/worker_scheduler_entrypoint.sh

COPY --from=prod_builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=prod_builder /usr/local/etc/php/php.ini /usr/local/etc/php/php.ini
COPY --from=prod_builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Caddy site configuration
COPY --from=prod_builder /etc/frankenphp /etc/frankenphp

# Shared libraries
COPY --from=prod_builder /tmp/libs /usr/lib

# CA certificates for TLS, file/libmagic for Symfony MIME type detection
COPY --from=prod_builder /etc/ssl/certs/ca-certificates.crt /etc/ssl/certs/ca-certificates.crt
COPY --from=prod_builder /etc/ssl/openssl.cnf /etc/ssl/openssl.cnf

# file/libmagic for MIME type detection
COPY --from=prod_builder /usr/bin/file /usr/bin/file
COPY --from=prod_builder /usr/lib/file/magic.mgc /usr/lib/file/magic.mgc

RUN <<-'EOF'
	mkdir -p /data/caddy /config/caddy
	chown -R 33:33 /data /config
	# Remove setuid/setgid bits
	find / -perm /6000 -type f -exec chmod a-s {} + 2>/dev/null || true
EOF

COPY --link --exclude=var --from=prod_builder /app /app
COPY --chown=33:33 --from=prod_builder /app/var /app/var

RUN install -d -o 33 -g 33 -m 775 /app/public/uploads && chown 33:33 /app/.env.local.php

# www-data, numeric so runtimes can verify runAsNonRoot
USER 33

WORKDIR /app

CMD ["/usr/local/bin/run_secrets.sh"]

FROM php:8.3-apache

WORKDIR /var/www/html/e-infantil
COPY . /var/www/html/e-infantil

RUN apt-get update -qy

RUN apt-get install -y \
    && apt-get install -y cron \
    && apt-get install -y libpq-dev \
    && apt-get install -y libpng-dev \
    && apt-get install -y libzip-dev \
    && apt-get install -y gnupg2 \
    && apt-get install tzdata \
    && apt-get install -y --no-install-recommends openssl \
    && sed -i -E 's/(CipherString\s*=\s*DEFAULT@SECLEVEL=)2/\11/' /etc/ssl/openssl.cnf \
    && apt-get install -y libxml2-dev \
    && docker-php-ext-install xml \
    && docker-php-ext-install ctype \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && docker-php-ext-install gd \
    && docker-php-ext-install opcache \
    && apt-get install -y unzip

RUN apt-get install -y \
    git

ENV APACHE_DOCUMENT_ROOT=/var/www/html/e-infantil/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

RUN apt-get install w3m -y

RUN mv "./compose/php/php.ini" "$PHP_INI_DIR/php.ini"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.3.4
RUN chmod 777 /usr/local/bin/composer
RUN pecl install docker-php-ext-enable \
        apcu \
        xdebug \
        docker-php-ext-enable xdebug

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
RUN apt-get install -y \
  libxml2-dev \
  && apt-get clean -y \
  && docker-php-ext-install soap

RUN apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev

RUN chmod +x ./compose/php/dev.sh

# Para iniciar o apache
RUN chown -R www-data:www-data /var/www/html/e-infantil/storage
RUN chown -R www-data:www-data /var/www/html/e-infantil/bootstrap/cache

# Para incluir os registros no LOG
RUN chmod -R ugo+rw /var/www/html/e-infantil/storage
RUN chmod -R ugo+rw /var/www/html/e-infantil/bootstrap/cache

COPY ./compose/php/iniciar_projeto_foreground.sh /usr/sbin/
RUN chmod +x /usr/sbin/iniciar_projeto_foreground.sh

RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime && \
    echo "America/Sao_Paulo" > /etc/timezone

RUN apt-get update && apt-get install vim -y

RUN sed -i 's/^exec /service cron start\n\nexec /' /usr/local/bin/apache2-foreground

RUN echo "*  *    * * *   root    cd /var/www/html/e-infantil && php artisan schedule:run >> /dev/null 2>&1" >> /etc/crontab

RUN apt-get install nodejs -y
RUN apt-get install npm -y

EXPOSE 8080

ENTRYPOINT ["sh", "-c", "/usr/sbin/iniciar_projeto_foreground.sh"]

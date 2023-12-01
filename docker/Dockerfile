# Build arguments
ARG IMAGE

FROM $IMAGE

RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install git -y

RUN apt-get install -y zlib1g-dev zip

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN rm -rf /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Rome /etc/localtime && echo Europe/Rome > /etc/timezone

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version
RUN composer self-update

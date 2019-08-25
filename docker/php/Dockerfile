FROM dockette/stretch

MAINTAINER Milan Sulc <sulcmil@gmail.com>

# PHP
ENV PHP_MODS_DIR=/etc/php/7.2/mods-available
ENV PHP_CLI_DIR=/etc/php/7.2/cli
ENV PHP_CLI_CONF_DIR=${PHP_CLI_DIR}/conf.d
ENV PHP_CGI_DIR=/etc/php/7.2/cgi
ENV PHP_CGI_CONF_DIR=${PHP_CGI_DIR}/conf.d
ENV PHP_FPM_DIR=/etc/php/7.2/fpm
ENV PHP_FPM_CONF_DIR=${PHP_FPM_DIR}/conf.d
ENV PHP_FPM_POOL_DIR=${PHP_FPM_DIR}/pool.d
ENV TZ=Europe/Prague

ARG XDEBUG_HOST

# INSTALLATION
RUN apt update && apt dist-upgrade -y && \
    # DEPENDENCIES #############################################################
    apt install -y wget curl apt-transport-https ca-certificates git && \
    # PHP DEB.SURY.CZ ##########################################################
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ stretch main" > /etc/apt/sources.list.d/php.list && \
    apt update && \
    apt install -y --no-install-recommends \
        php7.2-apc \
        php7.2-apcu \
        php7.2-bz2 \
        php7.2-bcmath \
        php7.2-calendar \
        php7.2-cgi \
        php7.2-cli \
        php7.2-ctype \
        php7.2-curl \
        php7.2-fpm \
        php7.2-geoip \
        php7.2-gettext \
        php7.2-gd \
        php7.2-intl \
        php7.2-imagick \
        php7.2-imap \
        php7.2-ldap \
        php7.2-mbstring \
#        php7.2-mcrypt \
        php7.2-memcached \
        php7.2-mongo \
        php7.2-mysql \
        php7.2-pdo \
        php7.2-pgsql \
        php7.2-redis \
        php7.2-soap \
        php7.2-sqlite3 \
        php7.2-ssh2 \
        php7.2-zip \
        php7.2-xmlrpc \
        php7.2-xsl \
        php7.2-xdebug \
        mysql-client # needed for drush pre-flight requests only

# COMPOSER #################################################################
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer global require "hirak/prestissimo:^0.3"

# DRUSH ####################################################################
RUN wget -O drush.phar https://github.com/drush-ops/drush-launcher/releases/download/0.6.0/drush.phar && \
    chmod +x drush.phar && \
    mv drush.phar /usr/local/bin/drush

# Drupal Console ###########################################################
RUN curl https://drupalconsole.com/installer -L -o drupal.phar && \
    mv drupal.phar /usr/local/bin/drupal && \
    chmod +x /usr/local/bin/drupal

# PHP MOD(s) ###############################################################
RUN ln -s ${PHP_MODS_DIR}/custom.ini ${PHP_CLI_CONF_DIR}/999-custom.ini && \
    ln -s ${PHP_MODS_DIR}/custom.ini ${PHP_CGI_CONF_DIR}/999-custom.ini && \
    ln -s ${PHP_MODS_DIR}/custom.ini ${PHP_FPM_CONF_DIR}/999-custom.ini

# CLEAN UP #################################################################
RUN rm ${PHP_FPM_POOL_DIR}/www.conf && \
    apt-get clean -y && \
    apt-get autoclean -y && \
#    apt-get remove -y wget curl && \
    apt-get autoremove -y && \
    rm -rf /var/lib/apt/lists/* /var/lib/log/* /tmp/* /var/tmp/*

# xDEBUG settings
RUN echo "xdebug.idekey = PHPSTORM" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.default_enable = 0" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.remote_enable = 1" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.remote_autostart = 0" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.remote_connect_back = 0" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.profiler_enable = 0" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.remote_host = $XDEBUG_HOST" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini && \
    echo "xdebug.remote_log=/srv/logs/xdebug.log" >> ${PHP_FPM_CONF_DIR}/20-xdebug.ini

# Coding standards
RUN composer global require drupal/coder && \
    composer global require dealerdirect/phpcodesniffer-composer-installer && \
    echo "alias drupalcs=\"~/.composer/vendor/bin/phpcs --standard=Drupal --extensions='php,module,inc,install,test,profile,theme,css,info,txt,md'\"" >> ~/.bashrc && \
    echo "alias drupalcsp=\"~/.composer/vendor/bin/phpcs --standard=DrupalPractice --extensions=\'php,module,inc,install,test,profile,theme,css,info,txt,md'\"" >> ~/.bashrc && \
    echo "alias drupalcbf=\"~/.composer/vendor/bin/phpcbf --standard=Drupal --extensions='php,module,inc,install,test,profile,theme,css,info,txt,md'\"" >> ~/.bashrc

ENV PATH="/root/.composer/vendor/bin:${PATH}"

# PhpUnit
RUN curl https://phar.phpunit.de/phpunit-6.phar -L > phpunit.phar \
  && chmod +x phpunit.phar \
  && mv phpunit.phar /usr/local/bin/phpunit \
  && phpunit --version

# FILES (it overrides originals)
ADD conf.d/custom.ini ${PHP_MODS_DIR}/custom.ini
ADD fpm/php-fpm.conf ${PHP_FPM_DIR}/php-fpm.conf

# WORKDIR
WORKDIR /srv

# COMMAND
CMD ["php-fpm7.2"]

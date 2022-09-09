FROM ubuntu:focal

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# make sure apt is up to date
RUN apt-get update
RUN apt install -y curl

ENV NVM_DIR=/root/.nvm
ENV NODE_VERSION=16.13.0

# Install nvm with node and npm
RUN curl https://raw.githubusercontent.com/creationix/nvm/v0.39.1/install.sh | bash 
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version

# Install php and composer 
RUN apt update
RUN apt install --no-install-recommends php8.1 -y
RUN apt-get install -y php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath -y
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# RUN mkdir /usr/app
# RUN mkdir /usr/app/log

WORKDIR /app

# log dir
# VOLUME /usr/app/log

# Bundle app source
COPY . /app
RUN mv .env.example .env

# Install npm app dependencies
RUN npm install
RUN npm install pm2@latest -g

# Install nano
RUN apt-get install nano -y

# Install php dependency
RUN composer install --ignore-platform-reqs
RUN apt-get install php-mysql -y
RUN php artisan key:generate


EXPOSE  3000
CMD ["node", "mainChecking.js"]

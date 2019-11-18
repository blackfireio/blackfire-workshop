#!/bin/bash

wget -q -O - https://packages.blackfire.io/gpg.key | apt-key add -
echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list
add-apt-repository -y ppa:ondrej/php

# install dependencies
apt-get update
apt-get install -qy zsh curl git firefox firefox-locale-en firefox-locale-fr
apt-get install -qy php7.3 php7.3-cli php7.3-fpm php7.3-curl php7.3-sqlite3 php7.3-pgsql php7.3-mysql php7.3-xml php7.3-zip php7.3-opcache php7.3-json php7.3-intl php7.3-mbstring 

# install composer
wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer

# create the blackfire user and add it to sudoer
useradd -m --home-dir=/home/blackfire --shell /bin/zsh blackfire
(echo 'blackfire'; echo 'blackfire') | passwd blackfire
cat /etc/sudoers.d/vagrant | sed 's/vagrant/blackfire/g' | tee /etc/sudoers.d/blackfire

su blackfire -c 'git clone https://github.com/blackfireio/blackfire-workshop.git /home/blackfire/blackfire-workshop'
su blackfire -c 'cd /home/blackfire/blackfire-workshop && composer install --no-interaction'

curl -sS https://get.symfony.com/cli/installer | bash
mv /root/.symfony/bin/symfony /usr/local/bin/symfony

su blackfire -c 'sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"'

# install phpstorm
snap install phpstorm --classic

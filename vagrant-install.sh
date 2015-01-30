#!/usr/bin/env bash

# Configurable variables
database='vagrant'
username='vagrant'
password='vagrant'
 
# Do not touch!
echo ''
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo '  Bootstrapping Ubuntu Precise 32bit for Laravel 4'
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo ''
echo '         Apache 2.2.22, PHP 5.4, MySQL 5.5'
echo ''
echo '   Based on Andrew13 and JeffreyWay bootstrappers'
echo ''
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo ''

# ---------------
#  Force use Google public DNS
# ---------------
echo '- Setting up Google public DNS'
echo "nameserver 8.8.8.8" >> /etc/resolvconf/resolv.conf.d/base
echo "nameserver 8.8.4.4" >> /etc/resolvconf/resolv.conf.d/base
resolvconf -u > /dev/null 2>&1

# ---------------
#  Various fixes
# ---------------
echo '- Fixing locales issues with Ubuntu'
update-locale LANG=en_US.UTF-8
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8
dpkg-reconfigure locales > /dev/null 2>&1

echo '- Configuring timezone to Brazil/East'
echo "Brazil/East" > /etc/timezone > /dev/null 2>&1
dpkg-reconfigure -f noninteractive tzdata > /dev/null 2>&1

# ------------------------
#  Update and basic tools
# ------------------------
echo '- Updating repositories'
apt-get update > /dev/null 2>&1

echo '- Installing vim'
apt-get install -y vim > /dev/null 2>&1

# ---------
#  PHP 5.4
# ---------    
echo '- Installing python-software-properties'
apt-get install -y python-software-properties > /dev/null 2>&1

echo '- Adding PHP 5.5 PPA'
add-apt-repository ppa:ondrej/php5-oldstable > /dev/null 2>&1

echo '- Updating repositories'
apt-get update --fix-missing > /dev/null 2>&1
apt-get upgrade > /dev/null 2>&1

echo '- Installing PHP 5.5'
apt-get install -y php5 > /dev/null 2>&1

echo '- Installing required PHP modules for Laravel 4'
apt-get install -y php5-mcrypt php5-gd php5-mysql php5-curl > /dev/null 2>&1

echo '- Enabling display errors on PHP'
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini > /dev/null 2>&1
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini > /dev/null 2>&1

# ------
#  cURL
# ------
echo '- Installing cURL'
apt-get install -y curl > /dev/null 2>&1

# ---------------
#  Apache 2.2.22
# ---------------
echo '- Installing Apache 2'
apt-get install -y apache2 > /dev/null 2>&1

echo '- Enabling Apache 2 mod_rewrite'
a2enmod rewrite > /dev/null 2>&1

echo '- Making apache allow override .htaccess files'
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/sites-available/default > /dev/null 2>&1

echo '- Setting up shared files'
rm -rf /var/www > /dev/null 2>&1
ln -fs /vagrant/public /var/www > /dev/null 2>&1

echo '- Setting up default site'
sed -i "s/DocumentRoot .*/DocumentRoot \/var\/www/" /etc/apache2/sites-available/default > /dev/null 2>&1

# -----------
#  MySQL 5.5
# -----------
echo '- Installing MySQL'
# Ignore the post install questions
export DEBIAN_FRONTEND=noninteractive
# Install MySQL quietly
apt-get -q -y install mysql-server > /dev/null 2>&1

echo '- Configuring MySQL settings'
echo "CREATE DATABASE IF NOT EXISTS $database" | mysql
echo "CREATE USER '$username'@'localhost' IDENTIFIED BY '$password'" | mysql
echo "GRANT ALL PRIVILEGES ON *.* TO '$username'@'localhost' IDENTIFIED BY '$password'" | mysql
echo "CREATE USER '$username'@'%' IDENTIFIED BY '$password'" | mysql
echo "GRANT ALL PRIVILEGES ON *.* TO '$username'@'%' IDENTIFIED BY '$password'" | mysql
echo "FLUSH PRIVILEGES" | mysql

echo '- Binding MySQL address'
sed -i 's/127.0.0.1/0.0.0.0/' /etc/mysql/my.cnf > /dev/null 2>&1

echo '- Refreshing all services'
service apache2 restart > /dev/null 2>&1
service mysql restart > /dev/null 2>&1

echo ''
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo '                 Bootstrapping done!'
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo ''
echo ' Your development environment is done'
echo ' Now you should migrate and seed your database'
echo ''
echo ' Hope you enjoy it!'
echo ' Made with <3 by pedrommone'
echo ''
echo ' ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~'
echo ''

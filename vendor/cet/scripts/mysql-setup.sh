#!/bin/bash

echo "=> Importing dashboard database"
mysql -uroot -e "create database dashboard;"
mysql -uroot -Ddashboard < /var/www/html/vendor/cet/scripts/dashboard.sql

echo "=> Importing kayako database"
mysql -uroot -e "create database kayako;"
mysql -uroot -Dkayako < /var/www/html/vendor/cet/scripts/kayako.sql

echo "=> Adding CET dashboard sample user"
mysql -uroot -e "CREATE USER 'user'@'%' IDENTIFIED BY 'password'"
mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION"

if [ ! -f /var/www/html/vendor/cet/config.inc.php ] ; then
	echo "=> Intializing sample config"
	cp -r /var/www/html/vendor/cet/config.sample.inc.php /var/www/html/vendor/cet/config.inc.php
fi
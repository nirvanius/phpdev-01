#!/bin/sh
#Не было времени толком разобраться, но что-то вроде этого
#вместо 123 надо указать свой пароль
echo 123 | sudo -S apt install -y\
curl -ygit\
php-fpm\
nginx\
mysql-server\
phpmyadmin\
#1/bin/bash

yum -y update
yum -y install mysql-server mysql-client mysql-server php-mysql mod_ssl httpd php php-mbstring


echo "character-set-server=utf-8" >> /etc/my.cnf
echo "[client]\ndefault-character-set=utf8 #clientセクションを追加]" >> /etc/my.cnf

chkconfig mysqld on
service mysqld start

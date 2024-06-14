#!/bin/sh

chown -R www-data:www-data /var/www/html/e-infantil/storage
chown -R www-data:www-data /var/www/html/e-infantil/bootstrap/cache
chmod -R ugo+rw /var/www/html/e-infantil/storage
chmod -R ugo+rw /var/www/html/e-infantil/bootstrap/cache
chmod -R ugo+rw  /var/www/html/e-infantil/storage/logs/.

# echo "Limpar cache ..." >> $NOMEARQUIVO
php -f /var/www/html/e-infantil/artisan optimize:clear
#php -f /var/www/html/e-infantil/artisan l5-swagger:generate

# echo "Baixar as novas branches ..." >> $NOMEARQUIVO
git fetch --all

sed -i 's/APP_AMB=.*/APP_AMB="Ambiente Desenvolvimento"/' /var/www/html/e-infantil/.env

service cron start

# echo "Iniciar o apache ..." >> $NOMEARQUIVO
#apachectl start
# apachectl -D FOREGROUND
/usr/sbin/apache2ctl -D FOREGROUND

#!/bin/bash
cd ~/
wget https://dl.eff.org/certbot-auto
chmod a+x certbot-auto
cd /opt/bitnami/apache2/conf/
rm server.crt -f
rm server.key -f
~/certbot-auto certonly --webroot -w /app -d www.gse-web.online --non-interactive --agree-tos -m cyberbobjr@yahoo.com

# Pour renouveler le certificat en mode DNS challenge
sudo ./certbot-auto -d *.gse-web.online -d gse-web.online --preferred-challenges dns certonly

cp /etc/letsencrypt/live/dev.gse-web.online/fullchain.pem /opt/bitnami/apache2/conf/server.crt
cp /etc/letsencrypt/live/dev.gse-web.online/privkey.pem /opt/bitnami/apache2/conf/server.key

cp /etc/letsencrypt/live/gse-web.online-0001/fullchain.pem /opt/bitnami/apache2/conf/server.crt
cp /etc/letsencrypt/live/gse-web.online-0001/privkey.pem /opt/bitnami/apache2/conf/server.crt



sudo ln -s /etc/letsencrypt/live/gse-web.online/fullchain.pem /opt/bitnami/apache2/conf/server.crt
sudo ln -s /etc/letsencrypt/live/gse-web.online/privkey.pem /opt/bitnami/apache2/conf/server.key

sudo /opt/bitnami/ctlscript.sh restart apache

openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout server.key -out server.crt

openssl genrsa -des3 -passout pass:avatar -out mysite.pass.key 2048
openssl rsa -passin pass:avatar -in mysite.pass.key -out server.key
openssl req -new -key server.key -out mysite.csr
openssl x509 -req -days 365 -in mysite.csr -signkey server.key -out server.crt

wget https://aws-codedeploy-eu-central-1.s3.eu-central-1.amazonaws.com/latest/install

# Procédure d'installation
* Utilisation de l'image Bitnami LAMP avec support PHP 7.2
* Bien déclarer la clef macbookpro.pem
* Mettre la bonne balise de déploiement (DEV ou PROD)
* Attention aux groupes de sécurité pour autoriser http/https/ssh
* Sur Amazon Linux, installation LAMP
    https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/install-LAMP.html
* Lancement du script letsencrypt.sh pour récupérer les certificats
    sudo apt-get install letsencrypt 
    sudo letsencrypt certonly --manual --preferred-challenges dns --register -d *.gse-web.online
* Installation de l'agent codedeploy
    wget https://aws-codedeploy-eu-central-1.s3.eu-central-1.amazonaws.com/latest/install
    https://docs.aws.amazon.com/codedeploy/latest/userguide/codedeploy-agent-operations-install.html
* Création du répertoire /app + droits 777 (selon l'environnement)
* Déclaration du ou des vhosts
* Déclaration du <Directory /app> => sinon 403
* Lancement pipeline bitbucket

-------

Mise à jour de la base de donnée

```
vendor/bin/phinx migrate -e dev
vendor/bin/phinx migrate -e demo
vendor/bin/phinx migrate -e prod
vendor/bin/phinx migrate -e circet
vendor/bin/phinx migrate -e circet-col2080
vendor/bin/phinx migrate -e circet-r5280
vendor/bin/phinx migrate -e circet-r5380-gard
```

-------

##### ec2-user #######

```
sudo yum update -y
sudo yum install -y httpd24 php73 php73-pdo_mysql php73-pdo php73-gd.x86_64 php73-intl.x86_64 php73-mbstring.x86_64
sudo service httpd start
sudo chkconfig httpd on
chkconfig --list httpd
sudo usermod -a -G apache ec2-user
groups
service httpd restart
sudo chown -R ec2-user:apache /app
sudo chmod 2775 /app
find /app -type d -exec sudo chmod 2775 {} \;
find /app -type f -exec sudo chmod 0664 {} \;
```

#### INSTALLATION REDIS SERVER ####

```
sudo yum install -y install redis
```

#### ROOT USER #####
Pour le client PHP Redis :

* Installation PECL

sudo yum install -y php73-devel php7-pear

* Installation du package redis

yum install php72-pecl-redis

* Création fichier ini

sudo echo "extension=redis.so" > /etc/php.d/30-redis.ini

* Relance httpd server

sudo service httpd restart

### Activer la compression gzip mod_deflate pour Apache
 * Création d'un fichier /etc/httpd/conf.d/gzip.conf avec le contenu suivant :
 
 ```
<IfModule mod_deflate.c>
  # Restrict compression to these MIME types
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE application/xhtml+xml
  AddOutputFilterByType DEFLATE text/xml
  AddOutputFilterByType DEFLATE application/xml
  AddOutputFilterByType DEFLATE application/xml+rss
  AddOutputFilterByType DEFLATE application/x-javascript
  AddOutputFilterByType DEFLATE text/javascript
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE image/png
  AddOutputFilterByType DEFLATE image/gif
  AddOutputFilterByType DEFLATE image/jpeg

  # Level of compression (Highest 9 - Lowest 1)
  DeflateCompressionLevel 9

  # Netscape 4.x has some problems.
  BrowserMatch ^Mozilla/4 gzip-only-text/html

  # Netscape 4.06-4.08 have some more problems
  BrowserMatch ^Mozilla/4\.0[678] no-gzip

  # MSIE masquerades as Netscape, but it is fine
  BrowserMatch \bMSI[E] !no-gzip !gzip-only-text/html

  <IfModule mod_headers.c>
    # Make sure proxies don't deliver the wrong content
    Header append Vary User-Agent env=!dont-vary
  </IfModule>
</IfModule>
```

Ne pas oublier le virtual host associé 

```
<VirtualHost *:80>
    DocumentRoot "/apps"
    ServerName dev.gse-web.online
</VirtualHost>

<Directory "/apps">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

```

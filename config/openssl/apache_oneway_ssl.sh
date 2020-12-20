#!/bin/bash


#APACHE_CONFIG_FILE="/etc/apache2/extra/httpd-vhosts.conf"
APACHE_CONFIG_FILE="httpd-vhosts.conf"

echo "
<VirtualHost *:443>
    ServerName localhost
    DocumentRoot "/Users/rhowlett/Sites/localhost"

    SSLCipherSuite HIGH:MEDIUM:!aNULL:!MD5
    SSLEngine on
    SSLCertificateFile /etc/apache2/ssl/server-cert.pem
    SSLCertificateKeyFile /etc/apache2/ssl/private/server-key.pem

    <Directory "/Users/rhowlett/Sites/localhost">
        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>
" | sudo tee $APACHE_CONFIG_FILE

apachectl restart

# Install CA cert (cacert.pem) manually

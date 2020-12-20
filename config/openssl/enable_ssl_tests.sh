#!/bin/bash

CA="ca"
#APACHE="/etc/apache2/ssl"
APACHE="./"
CERT="certs/server"
KEY="keys/server"
EXPORT="export/pkcs12"

openssl pkcs12 -export -in $APACHE/$CERT/server-cert.pem -inkey $APACHE/private/$KEY/server-key.pem -certfile $APACHE/$CA/cacert.pem -name "Server" -out $EXPORT/server-cert.p12

#!/bin/bash

#APACHE="/etc/apache2/ssl"
APACHE="./"
CA="ca"
CERT="certs/server"
KEY="keys/server"
EXPORT="export/pkcs12"

openssl pkcs12 -export -in $APACHE/$EXPORT/$CERT/server-cert.pem -inkey $APACHE/$EXPORT/private/$KEY/server-key.pem -certfile $APACHE/$EXPORT/$CA/cacert.pem -name "Server" -out server-cert.p12


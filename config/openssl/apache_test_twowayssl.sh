#!/bin/bash


APACHE="/etc/apache2/ssl"
CERT="certs/client"
kEY="keys/client"

openssl s_client -connect localhost:443 -tls1 -cert $APACHE/$CERT/client-cert.pem -key $APACHE/private/$KEY/client-key.pem

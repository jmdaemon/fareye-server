#!/bin/bash

#APACHE="/etc/apache2/ssl"
APACHE="."
CERT="certs/server"
PASS="password"
keytool -import -v -trustcacerts -keystore client_truststore.jks -storepass $PASS -alias server -file $APACHE/$CERT/server-cert.pem

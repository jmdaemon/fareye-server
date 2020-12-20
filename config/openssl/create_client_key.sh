#!/bin/bash

CA="ca"
CERT="certs/client"
KEY="keys/client"
EXPORT="export/pkcs12"
openssl pkcs12 -export -in $CERT/client-cert.pem -inkey private/$KEY/client-key.pem -certfile $CA/cacert.pem -name "Client" -out $EXPORT/client-cert.p12 


#!/bin/bash

CA="ca"
CSR="csr/client"
CERT="certs/client"
openssl ca -keyfile private/$CA/cakey.pem -cert $CA/cacert.pem -out $CERT/client-cert.pem -days 365 -config openssl.cnf -infiles $CSR/client-req.pem 

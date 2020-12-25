#!/bin/bash

CA="ca"
CSR="csr/server"
CERT="certs/server"
openssl ca -keyfile private/$CA/cakey.pem -cert $CA/cacert.pem -out $CERT/server-cert.pem -days 365 -config openssl.cnf -infiles $CSR/server-req.pem

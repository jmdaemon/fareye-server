#!/bin/bash

CSR="csr/client"
KEY="keys/client"
#openssl req -new -nodes -out $CSR/client-req.pem -keyout private/$KEY/client-key.pem -days 365 -config openssl.cnf
openssl req -new -nodes -out $CSR/client-req.pem -keyout private/$KEY/client-key.pem -days 365 -config openssl.client.cnf -batch
# TODO: Make another openssl.cnf with different client CN

#!/bin/bash

CSR="csr/server"
KEY="keys/server"
openssl req -new -nodes -out $CSR/server-req.pem -keyout private/$KEY/server-key.pem -days 365 -config openssl.cnf -batch

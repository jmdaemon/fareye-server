#!/bin/bash

OUTPUT="ca"

openssl req -new -x509 -extensions v3_ca -keyout private/$OUTPUT/cakey.pem -out $OUTPUT/cacert.pem -days 365 -config ./openssl.cnf


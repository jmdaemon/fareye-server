#!/bin/bash

openssl ca -out client-cert.pem -days 365 -config openssl.cnf -infiles client-req.pem 


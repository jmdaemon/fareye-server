#!/bin/bash

openssl req -new -nodes -out client-req.pem -keyout private/client-key.pem -days 365 -config openssl.cnf 

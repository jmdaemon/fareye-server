#!/bin/bash

openssl req -new -nodes -out server-req.pem -keyout private/server-key.pem -days 365 -config openssl.cnf

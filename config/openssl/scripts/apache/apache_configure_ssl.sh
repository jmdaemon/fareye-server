#!/bin/bash

#APACHE="/etc/apache2/ssl"
APACHE="./ssl"

mkdir $APACHE
cd $APACHE
mkdir certs private

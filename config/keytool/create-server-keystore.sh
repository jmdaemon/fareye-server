#!/bin/bash

PASS="password"
KEYPASS="pass"
#EXPORT="export/pkcs12"
EXPORT="pkcs12"
keytool -importkeystore -deststorepass $PASS -destkeypass $PASS -destkeystore server_keystore.jks -srckeystore $EXPORT/server-cert.p12 -srcstoretype PKCS12 -srcstorepass $KEYPASS -alias server


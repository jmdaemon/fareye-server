#!/bin/bash

PASS="password"
KEYPASS="pass"
keytool -importkeystore -deststorepass $PASS -destkeypass $PASS -destkeystore server_keystore.jks -srckeystore server-cert.p12 -srcstoretype PKCS12 -srcstorepass $KEYPASS -alias server


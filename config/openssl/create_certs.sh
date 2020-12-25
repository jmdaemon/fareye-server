#!/bin/bash


# https://www.robinhowlett.com/blog/2016/01/05/everything-you-ever-wanted-to-know-about-ssl-but-were-afraid-to-ask/

APACHE_DIR="./"

SERVER_CONF="openssl.cnf"
CLIENT_CONF="openssl.client.cnf"

# Options
PASS="pass"
DAYS="365"

# Output Files
SERIAL="database/serial"
CERT_INDEX="database/certindex.txt"

CA_CERT="ca/cacert.pem"
CA_KEY="private/ca/cakey.pem"

SERVER_CSR="csr/server/server-req.pem"
SERVER_KEY="private/keys/server/server-key.pem"
SERVER_CERT="certs/server/server-cert.pem"
SERVER_PKCS12="export/pkcs12/server-cert.p12"

CLIENT_CSR="csr/client/client-req.pem"
CLIENT_KEY="private/keys/client/client-key.pem"
CLIENT_CERT="certs/client/client-cert.pem"
CLIENT_PKCS12="export/pkcs12/client-cert.p12"

make_subdirs() { 
    mkdir -p ca \
        certs/server certs/client \
        csr/server csr/client \
        private/ca/ private/keys/server private/keys/client \
        database \
        "export/pkcs12"
}


setup_ssl() {
    echo '100001' > $SERIAL
    touch $CERT_INDEX
}

create_ca() { 
    openssl req -new -x509 -extensions v3_ca -keyout $CA_KEY -out $CA_CERT -days $DAYS -config $SERVER_CONF -passout pass:$PASS
}

create_server_certs() {
    openssl req -new -nodes -out $SERVER_CSR -keyout $SERVER_KEY -days $DAYS -config $SERVER_CONF -passout pass:$PASS
}

create_client_certs() {
    openssl req -new -nodes -out $CLIENT_CSR -keyout $CLIENT_KEY -days $DAYS -config $CLIENT_CONF -passout pass:$PASS
}

ca_sign_server() { 
    openssl ca -keyfile $CA_KEY -cert $CA_CERT -out $SERVER_CERT -days $DAYS -config $SERVER_CONF -infiles $SERVER_CSR
}

ca_sign_client() { 
    openssl ca -keyfile $CA_KEY -cert $CA_CERT -out $CLIENT_CERT -days $DAYS -config $SERVER_CONF -infiles $CLIENT_CSR
}

export_server_key() {
    openssl pkcs12 -export -in $APACHE$SERVER_CERT -inkey $APACHE$SERVER_KEY -certfile $APACHE$CA_CERT -name "Server" -out $APACHE$SERVER_PKCS12
}

export_client_key() { 
    openssl pkcs12 -export -in $APACHE$CLIENT_CERT -inkey $APACHE$CLIENT_KEY -certfile $APACHE$CA_CERT -name "Client" -out $APACHE$CLIENT_PKCS12
}

make_subdirs
setup_ssl
create_ca
create_server_certs
ca_sign_server
create_client_certs
ca_sign_client
export_server_key
export_client_key

# Set up Apache/Nginx for one-way SSL auth
# Set up Apache/Nginx for two-way SSL auth

#!/bin/bash

source make_subdirs.sh
source setup_ssl.sh

source create_ca.sh # Create CertAuth

source create_server_certs.sh   # Create server certificate
source ca_sign_server.sh        # Have the CertAuth sign the server's CSR

source create_client_certs.sh   # Create the client certificates
source ca_sign_client.sh        # Have the CertAuth sign the client's CSR

source create_client_key.sh     # Create the client key

# Set up Apache/Nginx for one-way SSL auth

# Set up Apache/Nginx for two-way SSL auth

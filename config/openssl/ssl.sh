#!/bin/bash

source make_subdirs.sh

# Configure ssl
source setup_ssl.sh

# Create CertAuth
source create_ca.sh

# Create server certificate
source create_server_certs.sh

# Have the CertAuth sign the server's CSR
source ca_sign_server.sh

# Create the client certificates
source create_client_certs.sh

# Have the CertAuth sign the client's CSR
source ca_sign_client.sh

# Create the client key
source create_client_key.sh

# Set up Apache/Nginx for one-way SSL auth

# Set up Apache/Nginx for two-way SSL auth

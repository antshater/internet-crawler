#!/bin/bash
set -e

POSTGRES="psql --username postgres"

echo "Creating database role: internet_crawler"

$POSTGRES <<-EOSQL
CREATE USER internet_crawler WITH CREATEDB PASSWORD 'internet_crawler';
ALTER USER internet_crawler WITH SUPERUSER;
EOSQL

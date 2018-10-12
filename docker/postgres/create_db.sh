#!/bin/bash
set -e

POSTGRES="psql --username internet_crawler -d postgres"

echo "Creating database: internet_crawler"

$POSTGRES <<EOSQL
CREATE DATABASE internet_crawler OWNER internet_crawler;
EOSQL

echo "Creating database: internet_crawler_tests"

$POSTGRES <<EOSQL
CREATE DATABASE internet_crawler_tests OWNER internet_crawler;
EOSQL

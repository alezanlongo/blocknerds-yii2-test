#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    # CREATE USER docker;
    CREATE DATABASE yii2;
    GRANT ALL PRIVILEGES ON DATABASE yii2 TO docker;
EOSQL
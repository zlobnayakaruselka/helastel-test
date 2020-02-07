#!/bin/bash
host=$(grep PERCONA_HOST ./../.env | xargs)
host=${host#*=}

port=$(grep PERCONA_PORT ./../.env | xargs)
port=${port#*=}

password=$(grep DB_PASSWORD ./../.env | xargs)
password=${password#*=}

mysql --port=${port} --host=${host} -uroot -p${password} < ./fixtures/schema.sql
mysql --port=${port} --host=${host} -uroot -p${password} < ./fixtures/data.sql

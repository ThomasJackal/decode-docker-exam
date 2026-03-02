#!/bin/sh
set -e

PGDATA="/var/lib/postgresql/data"
export PGDATA

# Use env vars (passed by docker-compose from .env)
POSTGRES_USER="${POSTGRES_USER}"
POSTGRES_PASSWORD="${POSTGRES_PASSWORD}"
POSTGRES_DB="${POSTGRES_DB}"

# Create dirs and fix ownership
mkdir -p "$PGDATA" /var/run/postgresql
chmod 700 "$PGDATA"
chown -R postgres:postgres "$PGDATA" /var/run/postgresql

# Initialize database if empty
if [ ! -s "$PGDATA/PG_VERSION" ]; then
  if [ -z "$POSTGRES_PASSWORD" ]; then
    echo "Error: POSTGRES_PASSWORD must be set (e.g. in .env)"
    exit 1
  fi
  # initdb with POSTGRES_USER as superuser
  su postgres -c "echo '$POSTGRES_PASSWORD' > /tmp/pw && initdb -D $PGDATA --username=$POSTGRES_USER --pwfile=/tmp/pw && rm -f /tmp/pw"
  # Allow TCP connections with password
  su postgres -c "echo \"host all all 0.0.0.0/0 scram-sha-256\" >> $PGDATA/pg_hba.conf"
  su postgres -c "echo \"listen_addresses = '*'\" >> $PGDATA/postgresql.conf"
  # Start temp server to create database
  su postgres -c "pg_ctl -D $PGDATA -o '-c listen_addresses=localhost' -w start"
  if ! PGPASSWORD="$POSTGRES_PASSWORD" psql -U "$POSTGRES_USER" -d postgres -tAc "SELECT 1 FROM pg_database WHERE datname='$POSTGRES_DB'" | grep -q 1; then
    PGPASSWORD="$POSTGRES_PASSWORD" psql -U "$POSTGRES_USER" -d postgres -c "CREATE DATABASE $POSTGRES_DB;"
  fi
  su postgres -c "pg_ctl -D $PGDATA -m fast -w stop"
  echo "PostgreSQL init process complete; ready for start up."
fi

# Run postgres as postgres user (su-exec so process gets signals)
exec su-exec postgres postgres -D "$PGDATA"

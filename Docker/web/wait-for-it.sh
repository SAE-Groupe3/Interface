#!/usr/bin/env bash
# wait-for-it.sh: Utilitaire pour attendre qu'un service soit disponible

set -e

host="$1"
shift
cmd="$@"

until nc -z "$host" 5432; do
  echo "En attente de PostgreSQL ($host:5432)..."
  sleep 1
done

echo "PostgreSQL est disponible !"
exec $cmd

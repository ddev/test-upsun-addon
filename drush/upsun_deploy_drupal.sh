#!/usr/bin/env bash

set -e

if [[ ! -d "web/sites/default/files" ]]; then
  echo "Creating sites/default/files directory"
  mkdir -p web/sites/default/files
fi

cd web
drush cache-rebuild
drush updatedb -y
drush config-import -y || true
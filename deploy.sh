#!/bin/sh
eval "$(ssh-agent -s)"
chmod 600 ./deploy_key
ssh-add ./deploy_key
ssh -T -i ./deploy_key ressourcesmont@montessori-ressources.net <<EOF
  pwd
  cd web
  git checkout feature/deploy-prod
  git pull
  print Use PHP7.3
  alias php='/opt/cpanel/ea-php73/root/usr/bin/php'

  print install packages
  php composer install # failing because memory_limit=32M

EOF

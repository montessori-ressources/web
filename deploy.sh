# This script is used to deploy the product to the production environment.
# See the .travis.yml file for more info.
#!/bin/sh
eval "$(ssh-agent -s)"
chmod 600 ./deploy_key
ssh-add ./deploy_key
ssh -T -i ./deploy_key ressourcesmont@montessori-ressources.net <<EOF
  cd web
  git checkout feature/deploy-prod
  git pull
  echo Use PHP7.3
  alias php='/opt/cpanel/ea-php73/root/usr/bin/php'

  echo install packages
  # Now support team have fixed the memory to 512M it work !
  php /opt/cpanel/composer/bin/composer install

EOF

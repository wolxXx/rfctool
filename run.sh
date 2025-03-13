#!/bin/bash

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";

docker compose up -d --build --force-recreate --pull always
docker exec rfctool-web sh -c "./composer.phar install"
docker exec rfctool-web sh -c "./install.sh"
docker exec rfctool-web sh -c "./composer.phar dbFull"
docker exec rfctool-web sh -c "./composer.phar paratestNoCoverage"

exit 0;
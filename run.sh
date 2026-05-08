#!/bin/bash

set -e

set -e
set -x
set -o
set pipefail

HERE=$(dirname $(readlink -f "$0"));
cd "$HERE";



check_docker() {
    if ! command -v docker &> /dev/null; then
        echo "Error: docker is not installed"
        exit 1
    fi
}

check_docker_compose() {
    if ! docker compose version &> /dev/null; then
        echo "Error: docker compose is not installed"
        exit 1
    fi
}

check_env_file() {
  if [ ! -f ".env" ]; then
      echo ".env file is missing."
      echo "Creating .env file from .env.dist."
      echo "please adjust the ports and names to your needs."
      cp .env.dist .env

      read -p "Do you want to edit the .env file with vim? (y/N): " response
      if [[ "$response" =~ ^[Yy]$ ]]; then
          vim .env
      else
          exit 0
      fi
  fi
}


check_docker
check_docker_compose
check_env_file


source .env


required_vars=("DB_PORT" "WEB_PORT")
missing_vars=()

for var_name in "${required_vars[@]}"; do
    if [ -z "${!var_name}" ]; then
        missing_vars+=("$var_name")
    fi
done

if [ ${#missing_vars[@]} -ne 0 ]; then
    echo "Error: The following variables are not set in .env file: ${missing_vars[*]}"
    exit 1
fi

check_docker() {
    if ! command -v docker &> /dev/null; then
        echo "Error: docker is not installed"
        exit 1
    fi
}

check_docker_compose() {
    if ! docker compose version &> /dev/null; then
        echo "Error: docker compose is not installed"
        exit 1
    fi
}

check_env_file() {
  if [ ! -f ".env" ]; then
      echo ".env file is missing."
      echo "Creating .env file from .env.example."
      echo "please adjust the ports and names to your needs."
      cp .env.example .env

      read -p "Do you want to edit the .env file with vim? (y/N): " response
      if [[ "$response" =~ ^[Yy]$ ]]; then
          vim .env
      else
          exit 0
      fi
  fi
}

check_docker
check_docker_compose
check_env_file

source .env

required_vars=(
"COMPOSE_PROJECT_NAME"
"DB_PORT"
"WEB_PORT"
)
missing_vars=()

for var_name in "${required_vars[@]}"; do
    if [ -z "${!var_name}" ]; then
        missing_vars+=("$var_name")
    fi
done

if [ ${#missing_vars[@]} -ne 0 ]; then
    echo "Error: The following variables are not set in .env file: ${missing_vars[*]}"
    exit 1
fi

docker compose --env-file .env --file docker-compose.yml  up -d --build --force-recreate --pull always

set +e
curl -s -o /dev/null http://localhost:"$WEB_PORT"

set -e

echo "web  running under http://localhost:$WEB_PORT"
echo "db running under $DB_PORT"


docker compose exec web sh -c "./composer.phar install"
docker compose exec web sh -c "./install.sh"
docker compose exec web sh -c "./composer.phar dbFull"
docker compose exec web sh -c "./composer.phar paratestNoCoverage"

echo "web running under http://localhost:$WEB_PORT"
echo "db running under port $DB_PORT"

exit 0;
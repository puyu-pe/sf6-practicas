#!/bin/bash
DOCKER_COMPOSE_PATH=".docker"
source ${DOCKER_COMPOSE_PATH}/.env
DOCKER_PHP="${APP_NAME}_php"

# node Yarn
# shellcheck disable=SC2139
alias yarn="U_ID=${UID} docker-compose --project-directory=${DOCKER_COMPOSE_PATH} --file ${DOCKER_COMPOSE_PATH}/docker-compose.yml run --rm nodejs yarn";

# php
alias php="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php";

# composer
alias composer="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} composer";

# symfony - bin/console
# shellcheck disable=SC2139
alias sf="U_ID=${UID} docker exec --user ${UID} -it ${DOCKER_PHP} php /var/www/html/bin/console";
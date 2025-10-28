docker run --detach -w /app --name init_env_docker --volume ./:/app idmarinas/php:8.4-xdebug

docker exec init_env_docker composer install --no-interaction

docker exec init_env_docker composer dev:dump:env --no-interaction

docker stop init_env_docker
docker rm init_env_docker

#!/bin/bash

alias php="docker-compose exec -u `id -u` php php"
alias artisan="docker-compose exec -u `id -u` php php artisan"
alias composer="docker-compose exec -u `id -u` php composer"
alias phpunit="docker-compose exec -u `id -u` php php vendor/bin/phpunit"
alias npm="docker-compose run -u `id -u` node npm"

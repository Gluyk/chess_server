env ?= .env
include $(env)

init:
	docker-compose --env-file .env up -d
	docker-compose exec -T php composer install --no-interaction
	echo "OK"

up:
	docker-compose --env-file .env up

upd:
	docker-compose --env-file .env up -d
	echo "OK"

upb:
	docker-compose --env-file .env up --build
	echo "OK"

updb:
	docker-compose --env-file .env up -d --build
	echo "OK"

stop:
	docker-compose --env-file .env stop
	echo "OK"

down:
	docker-compose --env-file .env down
	echo "OK"

ps:
	docker-compose --env-file .env ps

in:
	docker exec -it $(APP_NAME)_app sh

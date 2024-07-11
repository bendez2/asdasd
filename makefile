THIS_FILE := $(lastword $(MAKEFILE_LIST))

.PHONY: all run rabbitmq hyperf kafka redis minio mongodb zookeeper postgresql clickhouse

all: hyperf rabbitmq kafka redis minio mongodb zookeeper postgresql clickhouse

run: hyperf mongodb rabbitmq redis postgresql

hyperf:
	docker-compose --env-file ./.env -f ./docker-compose.yml up -d

kafka:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.kafka.yml up -d

redis:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.redis.yml up -d

minio:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.minio.yml up -d

mongodb:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.mongodb.yml up -d

zookeeper:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.zookeeper.yml up -d

postgresql:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.postgresql.yml up -d

clickhouse:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.clickhouse.yml up -d

rabbitmq:
	docker-compose --env-file ./.env -f ./infrastructureNotificationService/docker-compose.rabbitmq.yml up -d

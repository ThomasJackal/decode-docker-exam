## Build images

```bash
docker build -f docker/composer/Dockerfile -t decode-docker-composer .
docker compose -f docker-compose.bdd.yml build
docker compose -f docker-compose.app.yml build
```

## Run containers

```bash
docker compose -f docker-compose.bdd.yml up -d
docker compose -f docker-compose.app.yml up -d
```

## Execute migration

```bash
docker compose -f docker-compose.app.yml run --rm symfony php bin/console doctrine:migrations:migrate --no-interaction
```

## Endpoint

- **API** : http://localhost:8000/api/todos
- **Adminer** : http://localhost:8080/adminer.php

## Stop containers

```bash
docker compose -f docker-compose.bdd.yml down
docker compose -f docker-compose.app.yml down
```

## Use composer

```bash
docker run --rm -v ./symfony-app:/app -w /app decode-docker-composer [command] [args]
```

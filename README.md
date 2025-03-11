# car-showcase-api

Для того чтобы развернуть приложение необходимо выполнить
```bash
docker-compose up --build
```
далее зайти в контейнер api и выполнить
```bash
make deploy
```

Готово! приложение запущено на `http://localhost:8080/`

Для запуска тестов выполнить на контейнере api 
```bash
php bin/phpunit
```
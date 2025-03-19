Для запуску потрібно спочатку підняти контейнер з базою даних
`docker compose up -d --build db`

Залити дамп командою:
`docker compose exec db /bin/bash -c 'mysql -uroot -proot test < /var/tmp/test.sql'`

Збілдити контейнер PHP 
`docker compose up --build php`
# test_kma
Это тестовое задание KMA
# Установка
1. стянуть себе репозиторий
2. в репозитории выполнить `composer install`
3. в репозитории выполнить `docker-compose up -d`
# Использование
1. зайти в php контейнер `docker exec -it test-task-kma-php /bin/bash`
2. выполнить команду `php consume_messages.php`
3. зайти в php контейнер с другого терминала `docker exec -it test-task-kma-php /bin/bash`
4. выполнить команду `php push_messages.php`
5. Дождаться отправки всех 10 сообщений (при этом в обоих терминалах будет отображаться ход отправки и принятия сообщений)
6. завешить процесс consume_messages (ctrl+c)
7. выполнить команду `php get_data.php`

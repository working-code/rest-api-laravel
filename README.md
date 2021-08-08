## Написать приложение REST API для работы с задачами (Тестовое задание)

### Оглавление
- [Требования](#requirements)
- [Документация API](#documentation-api)
  - [Аутентификация](#auth)
  - [Ошибки](#error)
  - [Ресурс Task](#resource-task)
  - [Действия](#actions)
    - [Создание новой задачи](#create-task)
      - [Тело запроса](#request)
      - [Ответ](#response-request)
    - [Получение списка задач](#get-tasks)
      - [Ответ](#get-tasks-response)
- [Как запустить приложение](#install)
- [Как запустить тесты](#tests)
- [Как проверить API](#test-api)
  - [Swagger](#test-api-swagger)
  - [REST client](#test-api-client)


### <a name="requirements">Требования</a>
* Фреймворк Laravel
* MySQL или PostgreSQL
* Аутентификация через токен
* Валидация входных параметров
* Приложение должно быть опубликовано в GitHub, GitLab, Bitbucket.

## <a name="documentation-api">Документация API</a>
### <a name="auth">Аутентификация</a>
Токен доступа должен передаваться во всех обращениях к API в заголовке 

```
Authorization.
Authorization: Bearer ТОКЕН 
```

### <a name="error">Ошибки</a>
При возникновении ошибок, API отдает соответствующие HTTP-коды.

|Код | Описание |
|----|----------|
|400 |   Ошибка валидации |
|401 |  Ошибка авторизации (невалидный токен)| 


### <a name="resource-task">Ресурс Task</a>
```
{
"id": "integer",
"name": "string",
"description": "string",
"created_at": "string",
"updated_at": "string"
}
```

|Поле | type |Описание |
|-----|-----------|-----|
|id |            integer| Идентификатор задачи|
|name |          string | Наименование задачи|
|description |   string |Описание задачи|
|created_at  |  string |(date-time)  Время создания задачи Строка в формате RFC3339|
|updated_at | string |(date-time) Время обновления задачи Строка в формате RFC3339|


### <a name="actions">Действия</a>
#### <a name="create-task">Создание новой задачи</a>
POST /v1/tasks

**<a name="request">Тело запроса</a>**
```
{
"name": "string",
"description": "string"
}
```

|Поле | type |Описание |
|-----|-----------|-----|
|name |  string |  Наименование задачи (1-255 символов)|
|description|   string | Описание задачи (1-255 символов)|


**<a name="response-request">Ответ</a>**
```
HTTP Code: 201 Created
```
Ресурс Task

#### <a name="get-tasks">Получение списка задач</a>
GET /v1/tasks

**<a name="get-tasks-response">Ответ</a>**
```
HTTP Code: 200 OK
[]
```
Коллекция ресурсов Task

### <a name="install">Как запустить приложение</a>
Для запуска нам понадобится
- linux
- docker
- docker-compose
1. Клонируем проект
```
git clone git@github.com:working-code/rest-api-laravel.git
```
2. Переходим в каталог с проектом
```
cd rest-api-laravel
```
3. Устанавливаем нужные зависимости
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
```
4. Для работы с проектом используется утилита <a href="https://laravel.com/docs/8.x/sail" target="_blank">sail</a>. 
Для удобства установим алиас для sail
```
alias sail="bash vendor/bin/sail"
```
5. Переименовывем файл **.env.example** в **.env**. Задаем свои параметры для этих переменных
```
APP_URL=http://rest-api-laravel.test

DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=rest_api_laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
6. Добавляем host
```
sudo nano /etc/hosts
```
в конец файла добавляем 
```
127.0.0.1 rest-api-laravel.test
```

7. Запускаем проект
```
sail up
```

8. Запускам миграции
```
sail artisan migrate
```
9. Генерируем ключи passport
```
sail artisan passport:install
```
и сохраняем результат. Нам понадобится **Client ID**: 2 и **Client secret**

10. Заполняем базу тестовыми данными
```
sail artisan db:seed
sail artisan db:seed TaskSeeder
```

### <a name="tests">Как запустить тесты</a>
Приложение должно быть запущено.
```
sail test
```
![tests](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/tests.png)


### <a name="test-api">Как проверить API</a>
#### <a name="test-api-swagger">Swagger</a>
1. Перейдите на страницу документации
```
http://rest-api-laravel.test/api/documentation/
```
![swagger index](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_index.png)

2. Регестрация пользователя

![swagger reg 0](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg0.png)

![swagger reg 1](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg1.png)

![swagger reg 2](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg2.png)

![swagger reg 3](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg3.png)

3. Авторизируемся для следующих запросов

![swagger reg 4](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg4.png)

![swagger reg 5](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_reg5.png)

4. Получение списка задач

![swagger get task 0](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_get_task0.png)

![swagger get task 1](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_get_task1.png)

5. Создание задачи

![swagger get task 0](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_post_task0.png)

![swagger get task 0](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_post_task1.png)

![swagger get task 0](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/swagger_post_task2.png)



#### <a name="test-api-client">REST client</a>
Можно использовать любой клиент. В данном примере использовался <a href="https://github.com/RESTEDClient/RESTED">RESTED</a>
![1_registration](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/1_registration.png)

![2_getToken](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/2_getToken.png)

![3_createTask](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/3_createTask.png)

![4_getTasks](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/4_getTasks.png)

![5_badBearer](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/5_badBearer.png)

Написать приложение REST API для работы с задачами.

## Требования
* Фреймворк Laravel
* MySQL или PostgreSQL
* Аутентификация через токен
* Валидация входных параметров
* Приложение должно быть опубликовано в GitHub, GitLab, Bitbucket.

## Документация API
### Аутентификация
Токен доступа должен передаваться во всех обращениях к API в заголовке 

Authorization.\
Authorization: Bearer ТОКЕН \

### Ошибки
При возникновении ошибок, API отдает соответствующие HTTP-коды.
Код   Описание \
400   Ошибка валидации \
401   Ошибка авторизации (невалидный токен) 


### Ресурс Task
{\
"id": "integer",\
"name": "string",\
"description": "string",\
"created_at": "string",\
"updated_at": "string"\
}\

|Поле | type |Описание |
|-----|-----------|-----|
|id |            integer| Идентификатор задачи|
|name |          string | Наименование задачи|
|description |   string |Описание задачи|
|created_at  |  string |(date-time)  Время создания задачи Строка в формате RFC3339|
|updated_at | string |(date-time) Время обновления задачи Строка в формате RFC3339|


### Действия
#### Создание новой задачи
POST /v1/tasks

Тело запроса
{\
"name": "string",\
"description": "string"\
}

|Поле | type |Описание |
|-----|-----------|-----|
|name |  string |  Наименование задачи (1-255 символов)|
|description|   string | Описание задачи (1-255 символов)|


#### Ответ
HTTP Code: 201 Created\
Ресурс Task

#### Получение списка задач
GET /v1/tasks

Ответ\
HTTP Code: 200 OK\
[]

Коллекция ресурсов Task

### Screenshot!
![1_registration](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/1_registration.png)

![2_getToken](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/2_getToken.png)

![3_createTask](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/3_createTask.png)

![4_getTasks](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/4_getTasks.png)

![5_badBearer](https://github.com/working-code/rest-api-laravel/raw/master/screenshot/5_badBearer.png)

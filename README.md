# Configuration

преопределение штатного класса сущности

    link:
        db_driver: orm модель данных
        factory: App\Link\Factory\LinkFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Link\Entity\Link сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию 
        dto_class: App\Link\Dto\LinkDto класс dto с которым работает сущность
        decorates:
          command - декоратор mediator команд ссылок 
          query - декоратор mediator запросов ссылок
        services:
          pre_validator - переопределение сервиса валидатора ссылок
          handler - переопределение сервиса обработчика сущностей

# CQRS model

Actions в контроллере разбиты на две группы
создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE)
получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface


группы  сериализации

    1. API_GET_LINK, API_CRITERIA_LINK - получение ссылки
    2. API_POST_LINK - создание ссылки
    3. API_PUT_LINK -  редактирование ссылки

# Статусы:

    создание:
        ссылка создана HTTP_CREATED 201
    обновление:
        ссылка обновление HTTP_OK 200
    удаление:
        ссылка удален HTTP_ACCEPTED 202
    получение:
        ссылка(и) найдены HTTP_OK 200
    ошибки:
        если ссылка не найдена LinkNotFoundException возвращает HTTP_NOT_FOUND 404
        если ссылка не уникальна UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если ссылка не прошла валидацию LinkInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если ссылка не может быть сохранена LinkCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

Для добавления проверки поля сущности link нужно описать логику проверки реализующую интерфейс Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface и зарегистрировать сервис с этикеткой evrinoma.link.constraint.property

    evrinoma.link.constraint.property.custom:
        class: App\Link\Constraint\Property\Custom
        tags: [ 'evrinoma.link.constraint.property' ]

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
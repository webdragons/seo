Seo module
==========
Модуль управления SEO информацией для Bulldozer CMF

Установка
------------
Подключить в composer:
```
composer require bulldozer/seo "*"
```


Добавить в console\config\main.php:
```
return [
    'controllerMap' => [
        ...
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationNamespaces' => [
                ...
                'bulldozer\seo\console\migrations',
                ...
            ],
        ],
        ...
    ],
]
```
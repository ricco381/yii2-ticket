# yii2-ticket
Тикет система для yii2

Documentation in [English](https://github.com/ricco381/yii2-ticket/blob/master/README_EN.md)

##### Вышла стабильная версия 2.0.0
```
2.0.0
    Исправлены кодировки для mysql
    Исправлен баг с просмотром любых тикетов
    Добавлена возможность установки ID администратора для доступа в админ панель
    Убран доступ в админку для всех кроме администратора
```

##### Вышла стабильная версия 1.0.8
```
1.0.8
    Мелкие изменения
```

##### Вышла стабильная версия 1.0.7
```
1.0.7
    Изменен дизайн

1.0.6
    Добавлено прикрепление изображений.
    Добавлен создание тикета из админки.
    Добавление прификсов таблицы.
    Исправлен роутинг.

1.0.5
    Убраны уведомления о закрытых тикетах.
    Убран лишний код.
    Отправка почты перенесена в модель.

1.0.4 
    Добавлена загрузка картинок.

```

```
Установка composer require "ricco/yii2-ticket:2.0.0"
```

# Добавление в проект
```
'modules' => [
    'ticket' => [
        'class'         => ricco\ticket\Module::className(),
    ],
],
```
**Обязательно добавить в AppAssets в секцию js ссылку на bootstrap.js**
```
 public $js = [
        /** Другие скрипты */
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js',
    ];
```

# Маршруты без ЧПУ
```
index.php?r=ticket/ticket/index
index.php?r=ticket/admin/index
```

# Переопределение класса
```
'ticket' => [
            'class'         => ricco\ticket\Module::className(),
            'controllerMap' => [
                'admin' => [
                    'class' => \app\controllers\TicketAdminController::class,
                ],
            ],
        ],
```
# Переопределение вида
```
'view'         => [
            'theme' => [
                'pathMap' => [
                    '@ricco/ticket/views' => '@app/views/ticket',
                ],
            ],
        ],
```

# Статусы тикетов
> TicketHead::OPEN = 0 - открыт

> TicketHead::WAIT = 1 - Ожидание

> TicketHead::ANSWER = 2 - Отвечен

> TicketHead::CLOSED = 3 - Закрыт

# Доступные методы

> TicketHead::getNewTicketCount()

Возвращает количество всех тикетов у которых статус "0" или "1" 

> TicketHead::getNewTicketCountUser($status)

Возвращает количество текетов для текущего пользователя, по умолчанию со всеми статусами которые равняются "0"

# Миграция
```
yii migrate --migrationPath=@vendor/ricco/yii2-ticket/migrations
```

# Настройка модуля
```
$mailSendAnswer = true на email будут отправлятся уведомления об ответе

$subjectAnswer = string Тема email сообщения answer

$userModel = Object User model

$qq = array Массив отделов для которых создается вопрос

$admin = array Массив администраторов
```

# Публичная часть
![](http://i.imgur.com/AAptr3g.png)

# Создание тикета
![](http://i.imgur.com/D07htEF.png)

#Вопрос-Ответ
![](http://i.imgur.com/BkFcjJ2.png)

#Админка
![](http://i.imgur.com/r6veOiH.png)
#Ответ
![](http://i.imgur.com/HMrZFZu.png)
#Создание тикета
![](http://i.imgur.com/KtT3oeP.png)

# yii2-ticket
Тикет система для yii2

##### Вышла стабильная версия 1.0.1

```
Установка composer require "ricco/yii2-ticket:1.0.1"
```

# Добавление в проект
```
'ticket' => [
            'class'         => ricco\ticket\Module::className(),
        ],
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

# Ностройка модуля
```
$mailSendAnswer = true на email пользователя будут отправлятся уведомления об ответе

$mailSendClosed = true на email пользователя будут отправлятся уведомления о закрытии тикета

$subjectAnswer = string Тиема email сообщения answer

$subjectCloset = string Тема email сообщения closed
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

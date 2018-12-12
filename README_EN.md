# yii2-ticket
The ticket system for yii2

##### Stable version 2.0.0 released
```
2.0.0
     Fixed encodings for mysql
     Fixed bug with viewing any tickets
     Added the ability to set the administrator ID for access to the admin panel
     Removed
```

##### The stable version 1.0.8 has been released
```
1.0.8
     Minor changes
```

##### Released stable version 1.0.7
```
1.0.7
    Changed design

1.0.6
    Added attachment images.
    Added ticket creation from the admin panel.
    Add prefixo table.
    Fixed routing.

1.0.5
    Removed notifications about closed tickets.
    Removed unnecessary code.
    Sending mail is transferred to the model.

1.0.4
    Added download of images.

```

```
Install composer require "ricco/yii2-ticket:1.0.8"
```

# Add to project
```
'modules' => [
    'ticket' => [
        'class'         => ricco\ticket\Module::className(),
    ],
],
```
**Be sure to add in AppAssets section in js the link on bootstrap.js**
```
 public $js = [
        /** Other scripts */
        '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js',
    ];
```

# GET routes
```
index.php?r=ticket/ticket/index
index.php?r=ticket/admin/index
```

# Override class
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
# Override views
```
'view'         => [
            'theme' => [
                'pathMap' => [
                    '@ricco/ticket/views' => '@app/views/ticket',
                ],
            ],
        ],
```

# The status of the ticket
> TicketHead::OPEN = 0 - Open

> TicketHead::WAIT = 1 - Waiting

> TicketHead::ANSWER = 2 - Answered

> TicketHead::CLOSED = 3 - Closed

# Available methods

> TicketHead::getNewTicketCount()

Returns a count of all tickets with the status "0" или "1"

> TicketHead::getNewTicketCountUser($status)

Returns the number teketo for the current user, by default all statuses are equal to "0"

# Migration
```
yii migrate --migrationPath=@vendor/ricco/yii2-ticket/migrations
```

# Configuration of the module
```
$mailSendAnswer = true, email will be sent notifications about the answer

$subjectAnswer = string Subject line of email response

$userModel = model Object user

$qq = array of Array of departments to which the issue

$admin = array of Array administrators
```

# Public part
![](http://i.imgur.com/AAptr3g.png)

# Creating a ticket
![](http://i.imgur.com/D07htEF.png)

# Question-Answer
![](http://i.imgur.com/BkFcjJ2.png)

# Admin
![](http://i.imgur.com/r6veOiH.png)
# Admin-Answer
![](http://i.imgur.com/HMrZFZu.png)
# Admin Creating a ticket
![](http://i.imgur.com/KtT3oeP.png)
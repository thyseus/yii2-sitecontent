# Yii2-sitecontent

Tiny Sitecontent module for the Yii framework. Contains only one table where everything is stored.

## Installation

```bash
$ composer require thyseus/yii2-sitecontent
$ php yii migrate/up --migrationPath=@vendor/thyseus/yii2-sitecontent/migrations
```

## Configuration

Add following lines to your main configuration file:

```php
'modules' => [
    'sitecontent' => [
        'class' => 'thyseus\sitecontent\Module',
        'modelClass' => '\app\models\User', // optional. your User model. Needs to be ActiveRecord.
    ],
],
```

## Routes

Use the following routes to access the sitecontent module:

* index: https://your-domain/sitecontent/sitecontent/index
* view: https://your-domain/sitecontent/sitecontent/view?id=<slug>?lang=<lang>
* view: https://your-domain/sitecontent/sitecontent/view?id=<slug>

## License

Yii2-sitecontent is released under the GPLv3 License.

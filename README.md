# ATTENTION:

github has been bought by Microsoft. This repository is orphaned and has been moved to:

https://gitlab.com/thyseus/yii2-sitecontent

Thanks a lot for your understanding and blame Microsoft.

# Yii2-sitecontent

Very tiny and simple Sitecontent module for the Yii framework. Contains only one table where the sitecontent is stored.
Uses Summernote (http://summernote.org/) WYSIWYG Editor.

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

By default only users that apply to $user->can('admin') are allowed to access the sitecontent administation.
You can modify this with the 'accessCallback' configuration option.

## Routes

Use the following routes to access the sitecontent module:

* index: https://your-domain/sitecontent/sitecontent/index
* view: https://your-domain/sitecontent/sitecontent/view?id=<slug>?lang=<lang>
* view: https://your-domain/sitecontent/sitecontent/view?id=<slug>

## License

Yii2-sitecontent is released under the GPLv3 License.

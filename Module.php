<?php

namespace thyseus\sitecontent;

use Yii;
use yii\i18n\PhpMessageSource;

/**
 * Sitecontent module definition class
 */
class Module extends \yii\base\Module
{
    public $version = '0.1.0-dev';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'thyseus\sitecontent\controllers';

    public $defaultRoute = 'sitecontent\sitecontent\index';

    /**
     * @var string The layout to be used by the view action. Keep null to use the default layout.
     */
    public $layout = null;

    /**
     * @var string The class of the User Model inside the application this module is attached to
     */
    public $userModelClass = 'app\models\User';

    /**
     * @var array|false Options for the Summernote WYSIWYG editor plugin. Set to false to disable the plugin.
     */
    public $summernoteOptions = [
        'clientOptions' => [],
    ];

    /**
     * @var callback Rule to determine which users are allowed to access the content management system.
     * Defaults to Yii::$app->user->can('admin')
     */
    public $accessCallback = null;

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        'sitecontent/update/<language>/<id>' => 'sitecontent/sitecontent/update',
        'sitecontent/delete/<language>/<id>' => 'sitecontent/sitecontent/delete',
        'sitecontent/<language>/<id>' => 'sitecontent/sitecontent/view',
        'sitecontent/index' => 'sitecontent/sitecontent/index',
        'sitecontent/create' => 'sitecontent/sitecontent/create',
        'sitecontent/<id>' => 'sitecontent/sitecontent/view',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->accessCallback) {
            $this->accessCallback = function () {
                return Yii::$app->user->can('admin');
            };
        }

        if (!isset(Yii::$app->get('i18n')->translations['sitecontent*'])) {
            Yii::$app->get('i18n')->translations['sitecontent*'] = [
                'class' => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
                'sourceLanguage' => 'en-US'
            ];
        }
        parent::init();
    }
}

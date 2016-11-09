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
     * @var string The class of the User Model inside the application this module is attached to
     */
    public $userModelClass = 'app\models\User';

    /**
     * @inheritdoc
     */
    public function init()
    {
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

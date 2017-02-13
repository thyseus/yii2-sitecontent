<?php

namespace thyseus\sitecontent\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "sitecontent".
 *
 * @property string $id
 * @property string $parent
 * @property string $created_by
 * @property string $updated_by
 * @property string $language
 * @property string $position
 * @property integer $status
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 * @property string $views
 */
class Sitecontent extends ActiveRecord
{
    const STATUS_SYSTEM = -1;
    const STATUS_HIDDEN = 0;
    const STATUS_DRAFT = 1;
    const STATUS_PUBLIC = 2;
    const STATUS_RESTRICTED = 3;
    const STATUS_MOVED = 4;

    public static function getStatusOptions()
    {
        return [
            Sitecontent::STATUS_SYSTEM => Yii::t('sitecontent', 'system'),
            Sitecontent::STATUS_HIDDEN => Yii::t('sitecontent', 'hidden'),
            Sitecontent::STATUS_DRAFT => Yii::t('sitecontent', 'draft'),
            Sitecontent::STATUS_PUBLIC => Yii::t('sitecontent', 'public'),
            Sitecontent::STATUS_RESTRICTED => Yii::t('sitecontent', 'resticted'),
            Sitecontent::STATUS_MOVED => Yii::t('sitecontent', 'moved'),
        ];
    }

    public static function getLanguages()
    {
        $languages = [];

        foreach ((new \yii\db\Query())
                     ->select(['language'])
                     ->from(self::tableName())
                     ->groupBy('language')
                     ->indexBy('language')
                     ->all() as $lang)
            $languages[$lang['language']] = $lang['language'];

        return $languages;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sitecontent';
    }

    /* Retrieve raw content of an sitecontent entry, if available*/
    public static function getContent($id, $language = null)
    {
        $model = Sitecontent::findOne(['slug' => $id, 'language' => $language ? $language : Yii::$app->language]);

        if ($model)
            return $model->content;
        else
            return false;
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true,
                'ensureUnique' => true,
            ],
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'title'], 'required'],
            [['status', 'views', 'parent', 'position'], 'integer'],
            [['content', 'meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord && !$this->meta_title) {
            $this->meta_title = substr($this->title, 0, 70); // recommended max length
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sitecontent', '#'),
            'parent' => Yii::t('sitecontent', 'parent'),
            'created_by' => Yii::t('sitecontent', 'created by'),
            'updated_by' => Yii::t('sitecontent', 'last updated by'),
            'language' => Yii::t('sitecontent', 'language'),
            'position' => Yii::t('sitecontent', 'position'),
            'status' => Yii::t('sitecontent', 'status'),
            'slug' => Yii::t('sitecontent', 'slug'),
            'title' => Yii::t('sitecontent', 'title'),
            'content' => Yii::t('sitecontent', 'content'),
            'created_at' => Yii::t('sitecontent', 'created at'),
            'updated_at' => Yii::t('sitecontent', 'last updated at'),
            'views' => Yii::t('sitecontent', 'views'),
            'meta_title' => Yii::t('sitecontent', 'meta title'),
            'meta_description' => Yii::t('sitecontent', 'meta description'),
            'meta_keywords' => Yii::t('sitecontent', 'meta keywords'),
        ];
    }

    public function getParentSitecontent()
    {
        return $this->hasOne(Sitecontent::className(), ['id' => 'parent']);
    }

    public function getChilds()
    {
        return $this->hasMany(Sitecontent::className(), ['parent' => 'id']);
    }

    public function getCreatedBy()
    {
        return $this->hasOne(Yii::$app->getModule('sitecontent')->userModelClass, ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(Yii::$app->getModule('sitecontent')->userModelClass, ['id' => 'updated_by']);
    }
}

<?php

use thyseus\sitecontent\models\Sitecontent;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SitecontentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('sitecontent', 'Sitecontent');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecontent-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p> <?= Html::a(Yii::t('sitecontent', 'Add sitecontent'), ['create'], ['class' => 'btn btn-success']) ?> </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'parent',
                'filter' => ArrayHelper::map(Sitecontent::find()->all(), 'id', 'title'),
                'value' => function ($model) {
                    if ($model->parentSitecontent)
                        return $model->parentSitecontent->title;
                    else
                        return '';
                }
            ],
            'title',
            [
                'attribute' => 'language',
                'filter' => Sitecontent::getLanguages(),
            ],
            [
                'attribute' => 'status',
                'filter' => Sitecontent::getStatusOptions(),
                'value' => function ($model) {
                    return Sitecontent::getStatusOptions()[$model->status];
                },
            ],
            [
                'attribute' => 'created_by',
                'filter' => false,
                'value' => function ($model) {
                    return $model->createdBy ? $model->createdBy->username : null;
                },
            ],
            [
                'attribute' => 'updated_by',
                'filter' => false,
                'value' => function ($model) {
                    return $model->updatedBy ? $model->updatedBy->username : null;
                },
            ],
            ['attribute' => 'created_at', 'filter' => false],
            ['attribute' => 'updated_at', 'filter' => false],
            'views',
            [
                'class' => 'yii\grid\ActionColumn',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['sitecontent/' . $action, 'id' => $model->slug, 'language' => $model->language]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>

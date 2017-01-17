<?php

use karakum\grid\TreeGridView;
use thyseus\sitecontent\models\Sitecontent;
use yii\helpers\Html;
use yii\helpers\Url;
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

    <?= TreeGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'parentColumnName' => 'parent',
        'columns' => [
            [
                'format' => 'raw',
                'attribute' => 'title',
                'value' => function ($data) {
                    return Html::a($data->title, ['update', 'id' => $data->slug, 'language' => $data->language], ['data-pjax' => 0]);
                },
            ],
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
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return $model->status === Sitecontent::STATUS_PUBLIC;
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['sitecontent/' . $action, 'id' => $model->slug, 'language' => $model->language]);
                }
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>

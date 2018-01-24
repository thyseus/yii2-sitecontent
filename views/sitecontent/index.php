<?php

use thyseus\sitecontent\models\Sitecontent;
use yii\helpers\ArrayHelper;
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

    <p>
        <?= Html::a(Yii::t('sitecontent', 'Add sitecontent'), ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('sitecontent', 'Toggle Tree'), ['index', 'tree' => $tree ? 0 : 1], ['class' => 'btn btn-primary']) ?>

    </p>

    <?php $grid = $tree ? 'karakum\grid\TreeGridView' : 'karakum\grid\GridView'; ?>

    <?php $widget_options = [
        'dataProvider' => $dataProvider,
        'filterModel' => $tree ? false : $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width:50px;'],
            ],
            [
                'attribute' => 'parent',
                'value' => function ($model) { return $model->parentSitecontent ? $model->parentSitecontent->title : null; },
                'filter' => ArrayHelper::map(Sitecontent::getParentsGrouped(), 'id', 'title'),
            ],
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
            'views',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{copy}{delete}',
                'buttons' => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-copy"></span>', [
                            '//sitecontent/sitecontent/create', 'source_id' => $model->id, 'source_language' => $model->language],
                            ['title' => Yii::t('sitecontent', 'Copy'), 'data-pjax' => 0]);
                    },

                ],
                'visibleButtons' => [
                    'view' => function ($model, $key, $index) {
                        return $model->status === Sitecontent::STATUS_PUBLIC;
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(['sitecontent/' . $action, 'id' => $model->slug, 'language' => $model->language]);
                }
            ],
        ]
    ];

    if ($tree)
        $widget_options['parentColumnName'] = 'parent';

    Pjax::begin();
    echo $grid::widget($widget_options);
    Pjax::end(); ?>
</div>

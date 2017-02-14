<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

if ($model->title)
    Yii::$app->view->registerMetaTag(['name' => 'title', 'content' => $model->meta_title]);
if ($model->meta_description)
    Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
if ($model->meta_keywords)
    Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $model->meta_keywords]);
?>
<div class="sitecontent-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $model->content; ?> 
</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecontent', 'Sitecontent'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->slug, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sitecontent-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

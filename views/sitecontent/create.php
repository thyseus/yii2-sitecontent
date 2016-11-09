<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = Yii::t('sitecontent', 'Create Sitecontent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecontent', 'Sitecontent'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecontent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

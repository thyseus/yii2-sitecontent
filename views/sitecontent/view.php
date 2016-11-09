<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecontent-view">

    <div class="row">
        <div class="row-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= $model->content; ?>
        </div>
    </div>
</div>

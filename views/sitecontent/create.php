<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = Yii::t('sitecontent', 'Create Sitecontent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecontent', 'Sitecontent'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sitecontent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="sitecontent-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-1">
                <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-11">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('sitecontent', 'continue'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

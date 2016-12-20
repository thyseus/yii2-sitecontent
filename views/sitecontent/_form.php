<?php

use marqu3s\summernote\Summernote;
use thyseus\sitecontent\models\Sitecontent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sitecontent-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-12">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">

            <?= $form->field($model, 'parent')->dropDownList(
                ArrayHelper::map(Sitecontent::find()->all(), 'id', 'title'),
                ['prompt' => '-']); ?>

            <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'status')->dropDownList(Sitecontent::getStatusOptions()); ?>

        </div>

        <div class="col-md-8">
            <?php
            $summernoteOptions = Yii::$app->getModule('sitecontent')->summernoteOptions;

            if ($summernoteOptions === false)
                echo $form->field($model, 'content')->textArea(['rows' => 20]);
            else
                echo $form->field($model, 'content')->widget(Summernote::className(), $summernoteOptions);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('sitecontent', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

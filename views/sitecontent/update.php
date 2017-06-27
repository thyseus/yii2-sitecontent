<?php

use marqu3s\summernote\Summernote;
use thyseus\sitecontent\models\Sitecontent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sitecontent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('sitecontent', 'Sitecontent'), 'url' => ['index']];
if ($model->status === Sitecontent::STATUS_PUBLIC)
    $this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->slug, 'language' => $model->language]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sitecontent-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="sitecontent-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'parent')->dropDownList(
                    ArrayHelper::map(Sitecontent::find()->where(['!=', 'id', $model->id])->all(), 'id', 'title'),
                    ['prompt' => '-']); ?>

                <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList(Sitecontent::getStatusOptions()); ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>

                <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]); ?>

                <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]); ?>

                <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]); ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'created_by')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'updated_by')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'created_at')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'updated_at')->textInput(['disabled' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
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

</div>

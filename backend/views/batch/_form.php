<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Batch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="batch-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->hint('Ex: SLJSO-2016') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'year')->textInput(['maxlength' => true])->hint('Ex: 2016') ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'age_as_at')->widget(
                    DatePicker::className(), [
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'startView' => 'decade'
                ]
            ]);
            ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'date_of_examination')->widget(
                    DatePicker::className(), [
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'startView' => 'decade'
                ]
            ]);
            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'time')->textInput(['maxlength' => true])->hint('Ex: 9.30 -11.30 am') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusLabels()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

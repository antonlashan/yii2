<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Batch;

/* @var $this yii\web\View */
/* @var $model common\models\BatchExamCenters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="batch-exam-centers-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'batch_id')->dropDownList(ArrayHelper::map(Batch::find()->asArray()->all(), 'id', 'name')) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

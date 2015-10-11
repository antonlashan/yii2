<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\StudentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['students'],
                'method' => 'get',
    ]);
    ?>

    <?= $form->field($model, 'academic_year') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
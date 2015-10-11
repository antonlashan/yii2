<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $userDetail common\models\UserDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
	<div class="row">

		<div class="col-md-12">
		    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true])->label('Name of the Applicant')->hint('Ex: Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon') ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'initials')->textInput(['maxlength' => true])->hint('Ex: T M T N M K Tennakoon') ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'gender')->dropDownList($userDetail->getGenderLabels(), ['prompt' => '- select gender -']) ?>
		</div>
		<div class="col-md-6">
		    <?=
		    $form->field($userDetail, 'dob')->widget(
			    DatePicker::className(), [
			    'clientOptions' => [
				    'autoclose' => true,
				    'format' => 'yyyy-mm-dd',
				    'startView' => 'decade'
			    ]
		    ]);
		    ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'college_and_address')->textarea() ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'telephone')->textInput(['maxlength' => true]) ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('e-mail') ?>
		</div>
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'medium')->dropDownList($userDetail->getMediumLabels(), ['prompt' => '- select medium -']) ?>
		</div>

	</div>
	<div class="row">
		<div class="col-md-6">
		    <?= $form->field($userDetail, 'confirm')->checkbox() ?>
		</div>
	</div>
	<div class="clearfix form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
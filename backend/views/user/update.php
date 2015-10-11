<?php

use common\models\UserDetail;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$this->title = 'Update User: ' . ' ' . $user->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->full_name, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<div class="user-form">

		<?php $form = ActiveForm::begin(); ?>

		<div class="row">
			<div class="col-md-3">
			    <?= $form->field($user, 'is_admin')->dropDownList($user->getIsAdminLabels()) ?>
			</div>
			<div class="col-md-9">

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($user, 'title')->dropDownList($user->getTitleLabels(), ['prompt' => '- select title -']) ?>
			</div>
			<div class="col-md-6">
			    <?= $form->field($user, 'full_name') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group field-user-email">
					<label for="user-email" class="control-label">Email</label>
					<label class="form-control"><?= $user->email ?></label>

					<div class="help-block"></div>
				</div>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_email', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_EMAIL_YES, 'uncheck' => UserDetail::VISIBILITY_EMAIL_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'membership_number') ?>
			</div>
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'member_category_id')->dropDownList($memberCategoryList, ['prompt' => '- Select category -']) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'present_position') ?>
			</div>
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'affiliation') ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'phone_office') ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_phone_office', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_PHONE_OFFICE_YES, 'uncheck' => UserDetail::VISIBILITY_PHONE_OFFICE_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'phone_residence') ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_phone_residence', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_PHONE_RESIDENCE_YES, 'uncheck' => UserDetail::VISIBILITY_PHONE_RESIDENCE_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'phone_mobile') ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_phone_mobile', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_PHONE_MOBILE_YES, 'uncheck' => UserDetail::VISIBILITY_PHONE_MOBILE_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'official_address')->textarea() ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_official_address', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_OFFICIAL_ADDRESS_YES, 'uncheck' => UserDetail::VISIBILITY_OFFICIAL_ADDRESS_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'permanent_address')->textarea() ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'visibility_permanent_address', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::VISIBILITY_PERMANENT_ADDRESS_YES, 'uncheck' => UserDetail::VISIBILITY_PERMANENT_ADDRESS_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?=
			    $form->field($userDetail, 'payment_due_date')->widget(
				    DatePicker::className(), [
				    'clientOptions' => [
					    'autoclose' => true,
					    'format' => 'yyyy-mm-dd'
				    ]
			    ]);
			    ?>
			</div>
			<div class="col-md-6">
				<label>&nbsp;</label>
				<?= $form->field($userDetail, 'payment_overdue', ['template' => "{input}\n{label}\n{hint}\n{error}"])->checkbox(['value' => UserDetail::OVERDUE_YES, 'uncheck' => UserDetail::OVERDUE_NO], false) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			    <?= $form->field($userDetail, 'professional_qualifications')->textarea() ?>
			</div>
			<div class="col-md-6">
			    <?=
			    $form->field($userDetail, 'qualifications')->widget(Select2::classname(), [
				    'data' => $qualificationList,
				    'options' => [
					    'placeholder' => 'Select qualifications ...',
					    'multiple' => true,
				    ],
				    'pluginOptions' => [
					    'allowClear' => true
				    ],
			    ])
			    ?>
			    <?=
			    $form->field($userDetail, 'specializations')->widget(Select2::classname(), [
				    'data' => $specializationList,
				    'options' => [
					    'placeholder' => 'Select specializations ...',
					    'multiple' => true,
				    ],
				    'pluginOptions' => [
					    'allowClear' => true
				    ],
			    ])
			    ?>
			</div>
		</div>

		<div class="form-group">
			<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
			<?= Html::submitButton($user->isNewRecord ? 'Create' : 'Update', ['class' => $user->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>

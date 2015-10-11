<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$userId = \Yii::$app->user->id;
?>
<div class="user-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
	    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
	    <?=
	    Html::a('Delete', ['delete', 'id' => $model->id], [
		    'class' => 'btn btn-danger',
		    'data' => [
			    'confirm' => 'Are you sure you want to delete this item?',
			    'method' => 'post',
		    ],
	    ])
	    ?>
	</p>

	<?=
	DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			[
				'attribute' => 'title',
				'value' => $model->getTitleLabel(),
			],
			'full_name',
			'email:email',
			[
				'attribute' => 'is_admin',
				'value' => $model->getIsAdminLabel(),
			],
			[
				'attribute' => 'status',
				'value' => $model->getStatusLabel(),
			],
			'created_at',
			'updated_at',
		],
	])
	?>

	<?php if ($model->userDetail) { ?>
		<p>Member Details</p>
		<?=
		DetailView::widget([
			'model' => $model->userDetail,
			'attributes' => [
				'membership_number',
				[
					'attribute' => 'member_category_id',
					'value' => $model->userDetail->memberCategory->name,
				],
				'present_position',
				'affiliation',
				[
					'attribute' => 'phone_office',
					'value' => $model->userDetail->phone_office,
				],
				[
					'attribute' => 'phone_residence',
					'value' => $model->userDetail->phone_residence,
				],
				[
					'attribute' => 'phone_mobile',
					'value' => $model->userDetail->phone_mobile,
				],
				[
					'attribute' => 'official_address',
					'value' => $model->userDetail->official_address,
				],
				[
					'attribute' => 'permanent_address',
					'value' => $model->userDetail->permanent_address,
				],
				'professional_qualifications',
				[
					'attribute' => 'qualifications',
					'value' => $model->userDetail->getFormattedMQualifications(),
				],
				[
					'attribute' => 'specializations',
					'value' => $model->userDetail->getFormattedMSpecializations(),
				],
				'payment_due_date',
				[
					'attribute' => 'payment_overdue',
					'value' => $model->userDetail->getOverdueLabel(),
				],
			],
		])
		?>

		<p>Visibility</p>
		<?=
		DetailView::widget([
			'model' => $model->userDetail,
			'attributes' => [
				[
					'attribute' => 'visibility_email',
					'value' => $model->userDetail->getVisibilityEmailLabel(),
				],
				[
					'attribute' => 'visibility_official_address',
					'value' => $model->userDetail->getVisibilityOfficialAddressLabel(),
				],
				[
					'attribute' => 'visibility_permanent_address',
					'value' => $model->userDetail->getVisibilityPermanentAddressLabel(),
				],
				[
					'attribute' => 'visibility_phone_office',
					'value' => $model->userDetail->getVisibilityPhoneOfficeLabel(),
				],
				[
					'attribute' => 'visibility_phone_residence',
					'value' => $model->userDetail->getVisibilityPhoneResidenceLabel(),
				],
				[
					'attribute' => 'visibility_phone_mobile',
					'value' => $model->userDetail->getVisibilityPhoneMobileLabel(),
				],
			],
		])
		?>
	<?php } ?>

</div>

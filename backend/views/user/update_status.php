<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update User: ' . ' ' . $model->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->full_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update Status';
?>
<div class="user-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<div class="user-form">

		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'status')->dropDownList(User::instantiate(null)->getStatusLabels()) ?>

		<div class="form-group">
			<?= Html::a('Cancel', ['index'], ['class' => 'btn btn-primary']) ?>
			<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>

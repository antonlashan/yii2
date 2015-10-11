<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Batches';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
	    <?= Html::a('Create Batch', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?=
	GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name',
			'year',
			'age_as_at',
			'date_of_examination',
			'time',
			'examination_center',
			// 'counter',
			[
				'attribute' => 'status',
				'value' => function($data) {
					return $data->getStatusLabel();
				}
			],
			['class' => 'yii\grid\ActionColumn'],
		],
	]);
	?>

</div>
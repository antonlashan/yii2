<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Batch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exam Centers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-exam-centers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Exam Center', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'filterModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'batch.name',
                'value' => 'batch.name',
                'filter' => Html::activeDropDownList($searchModel, 'batch_id', ArrayHelper::map(Batch::find()->asArray()->all(), 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Select Category']),
            ],
            'name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

</div>

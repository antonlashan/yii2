<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Batch */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-view">

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
            'name',
            'year',
            'age_as_at',
            'date_of_examination',
            'time',
            [
                'attribute' => 'status',
                'value' => $model->getStatusLabel(),
            ],
        ],
    ])
    ?>

    <?php if (!empty($model->batchExamCenters)) { ?>
        <table class="table table-striped table-bordered detail-view">
            <tbody>
                <tr><th>Examination Centers</th></tr>
                <?php foreach ($model->batchExamCenters as $center) { ?>
                    <tr><td><?= $center->name ?></td></tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

</div>

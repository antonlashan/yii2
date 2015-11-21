<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserDetail */

$this->title = 'Update Student';
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['students']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-student', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->user_id], [
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
            'user.full_name',
            'initials',
            'user.email',
            'reg_no',
            [
                'attribute' => 'gender',
                'value' => $model->getGenderLabel(),
            ],
            'dob',
            'examCenter.name',
            'telephone',
            [
                'attribute' => 'medium',
                'value' => $model->getMediumLabel(),
            ],
            [
                'attribute' => 'academic_year',
                'value' => $model->batch->name,
            ],
        ],
    ])
    ?>

</div>
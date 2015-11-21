<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BatchExamCenters */

$this->title = 'Update Exam Center: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Exam Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="batch-exam-centers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>

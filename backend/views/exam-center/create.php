<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BatchExamCenters */

$this->title = 'Create Batch Exam Centers';
$this->params['breadcrumbs'][] = ['label' => 'Batch Exam Centers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-exam-centers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

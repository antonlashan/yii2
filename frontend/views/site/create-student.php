<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Regstration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'userDetail' => $userDetail,
        'batch' => $batch,
        'examCenters' => $examCenters,
    ])
    ?>

</div>
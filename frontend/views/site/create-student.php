<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */
use yii\helpers\Html;

$this->title = 'Regstration';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    #userdetail-payment_mathod label{margin-right: 15px;}
</style>
<div class="user-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'userDetail' => $userDetail,
        'batch' => $batch,
        'examCenters' => $examCenters,
    ])
    ?>
    <span><strong>Main Sponsorship</strong></span>
    <a title="Boc" target="_blank" href="http://web.boc.lk/index.php"><?= Html::img('@web/img/boc.png', ['alt' => 'Boc']) ?></a>
    <a title="Facebook" target="_blank" href="https://www.facebook.com/jsosrilanka"><?= Html::img('@web/img/find-us-facebook.png', ['alt' => 'Find us on Facebook']) ?></a>
</div>
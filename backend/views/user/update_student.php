<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update Student';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">


<?=
$this->render('_form_student', [
    'user' => $user,
    'userDetail' => $userDetail,
    'examCenters' => $examCenters,
])
?>

</div>
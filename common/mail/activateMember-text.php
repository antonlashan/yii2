<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/login']);
?>
Hi $user->full_name ?>,

your profile has been activated. 

Please follow the <?= $loginLink ?> to login

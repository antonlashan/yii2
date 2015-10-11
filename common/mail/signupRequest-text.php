<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

//$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
User <?= $user->full_name ?> has requested a become a member. 

Follow the link below to reset your password:

<?php // $resetLink ?>

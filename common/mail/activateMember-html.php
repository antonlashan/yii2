<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$loginLink = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['site/login']);
?>
<div class="password-reset">
	<p>Hi <?= Html::encode($user->full_name) ?>,</p>
	<p>your profile has been activated. </p>

	<p>Please follow the <?= Html::a('link', $loginLink) ?> to login</p>
</div>

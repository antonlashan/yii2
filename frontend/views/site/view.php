<?php

use yii\helpers\Html;
use common\models\UserDetail;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $batch common\models\Batch */
$this->title = 'Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    body { font-family: verdana, sans-serif;} 

    th,td {
        padding: 3px;
    }

    table.collapse2 {
        border-collapse: collapse;
        border: 1px solid black;
    }

    table.collapse2 td {
        border: 1px solid black;
    }
	@page { margin: 10px 10px; }
body { margin: 10px 10px; }
</style>
<table width="<?= ($pdf ? '50%' : '600px') ?>" class="collapse2">
    <tbody>
        <tr>
            <td colspan="4">
                <table width="100%">
                    <tbody>
                        <tr>
                            <th width="25%"><?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/logo.png') ?></th>
                            <th width="50%" align="center"><h3><?= strtoupper(Yii::$app->name . ' - ' . $batch->year . ' Admission') ?></h3></th>
                    <th width="25%" align="right"><?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/default_avatar.png') ?></th>
        </tr>
    </tbody>
</table>		    
</td>
</tr>
<tr>
    <td>Name of the Applicant</td>
    <td colspan="3"><?= $user->full_name ?></td>
</tr>
<tr>
    <td><?= $user->userDetail->getAttributeLabel('initials') ?></td>
    <td colspan="3"><?= $user->userDetail->initials ?></td>
</tr>
<tr>
    <td><?= $user->userDetail->getAttributeLabel('reg_no') ?></td>
    <td><?= $user->userDetail->reg_no ?></td>
    <td><?= $user->userDetail->getAttributeLabel('gender') ?></td>
    <td><?= $user->userDetail->getGenderLabel() ?></td>
</tr>
<tr>
    <td><?= $user->userDetail->getAttributeLabel('payment_mathod') ?></td>
    <td><?= $user->userDetail->getPaymentMethodLabel() ?></td>
    <?php if ($user->userDetail->payment_mathod == UserDetail::PAYMENT_M_BANK) { ?>
        <td><?= $user->userDetail->getAttributeLabel('payment_date') ?>: <?= $user->userDetail->payment_date ?></td>
        <td><?= $user->userDetail->getAttributeLabel('bank_branch') ?>: <?= $user->userDetail->bank_branch ?></td>
    <?php } ?>
</tr>
<tr>
    <td><?= $user->userDetail->getAttributeLabel('dob') ?></td>
    <td><?= $user->userDetail->dob ?></td>
    <td>Age as at <?= date("d F", strtotime($batch->age_as_at)) ?></td>
    <td><?= $batch->getAgeAsAt($user->userDetail->dob) ?></td>
</tr>
<tr>
    <td width="25%"><?= $user->userDetail->getAttributeLabel('exam_center_id') ?></td>
    <td width="25%"><?= (!empty($user->userDetail->examCenter) ? $user->userDetail->examCenter->name : '') ?></td>
    <td width="25%"><?= $user->userDetail->getAttributeLabel('telephone') ?></td>
    <td width="25%"><?= $user->userDetail->telephone ?></td>
</tr>
<tr>
    <td colspan="2"></td>
    <td><?= $user->getAttributeLabel('email') ?></td>
    <td><?= $user->email ?></td>
</tr>
<tr>
    <td><?= $batch->getAttributeLabel('date_of_examination') ?></td>
    <td colspan="3"><?= $batch->date_of_examination ?></td>
</tr>
<tr>
    <td><?= $batch->getAttributeLabel('time') ?></td>
    <td><?= $batch->time ?></td>
    <td><?= $user->userDetail->getAttributeLabel('medium') ?></td>
    <td><?= $user->userDetail->getMediumLabel() ?></td>
</tr>
<tr>
    <td colspan="4">
		I state that the above particulars are true and correct and agree with the rules and regulations of the competition.<br/>
        <?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/text_1.jpg') ?>
        <br/>
        <br/>
        Signature
    </td>
</tr>
<tr>
    <td colspan="4">
        I certify that the applicant named on this form did appearpersonally before me and the photograph affixed hereto is of applicant.<br/>
        <?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/text_2.jpg') ?>
    </td>
</tr>
<tr>
    <td colspan="3">

        Name and Signature, stamp  of the Attester<br/>
        <?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/text_3.jpg') ?>
    </td>
    <td></td>
</tr>
<tr>
    <td colspan="4" >
        Paste the bank voucher here<br/>
        <?= Html::img('@web' . ($pdf ? 'root' : '') . '/img/text_4.jpg') ?>
    </td>
</tr>
</tbody>
</table>

<?php
if (isset($id)) {
    echo "<br/>";
    echo Html::a('Download', ['pdf', 'id' => $id], ['class' => 'btn btn-info']);
}
?>
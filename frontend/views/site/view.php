<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $batch common\models\Batch */
$this->title = 'Details';
$this->params['breadcrumbs'][] = $this->title;
//$this->registerCss('');
?>
<style>
    body { font-family: verdana, sans-serif;} 

    th,td {
        padding: 3pt;
    }

    table.collapse2 {
        border-collapse: collapse;
        border: 1pt solid black;  
        font-size: 0.95em;
    }

    table.collapse2 td {
        border: 1pt solid black;
    }
</style>
<table width="<?= ($pdf ? '100%' : '800px') ?>" class="collapse2">

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
<tbody>
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
        <td colspan="3"><?= $user->userDetail->reg_no ?></td>
    </tr>
    <tr>
        <td><?= $user->userDetail->getAttributeLabel('gender') ?></td>
        <td colspan="3"><?= $user->userDetail->getGenderLabel() ?></td>
    </tr>
    <tr>
        <td><?= $user->userDetail->getAttributeLabel('dob') ?></td>
        <td><?= $user->userDetail->dob ?></td>
        <td>Age as at <?= date("d F", strtotime($batch->age_as_at)) ?></td>
        <td><?= $batch->getAgeAsAt($user->userDetail->dob) ?></td>
    </tr>
    <tr>
        <td width="25%"><?= $user->userDetail->getAttributeLabel('college_and_address') ?></td>
        <td width="25%"><?= $user->userDetail->college_and_address ?></td>
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
        <td><?= $batch->getAttributeLabel('examination_center') ?></td>
        <td colspan="3"><?= $batch->examination_center ?></td>
    </tr>
    <tr>
        <td><?= $batch->getAttributeLabel('time') ?></td>
        <td><?= $batch->time ?></td>
        <td><?= $user->userDetail->getAttributeLabel('medium') ?></td>
        <td><?= $user->userDetail->getMediumLabel() ?></td>
    </tr>
    <tr>
        <td colspan="4">
            I state that the above particulars are true and correct and agree with the rules and regulation of the competition<br/><br/>Signature
        </td>
    </tr>
    <tr>
        <td colspan="4">
            I certify that the applicant named on this form did appearpersonally before me and the photograph affixed hereto is of applicant.<br/>
            <span style="font-family:aaaaa">
                அத² கோ² ஸுதி³ன்னோ கலந்த³புத்தோ அசிரவுட்டி²தாய பரிஸாய யேன ப⁴க³வா தேனுபஸங்கமி<br/>
            </span>

        </td>
    </tr>
    <tr>
        <td>

            Name and Signature, stamp  of the Attester<br/>
            <span style="font-family:aaaaa">
                அத² கோ² ஸுதி³ன்னோ கலந்த³புத்தோ<br/>
                කොමන්ස් ඇට්‍රිබ්යුශන්/ශෙයා-අලයික් වරපතට යටත්ව<br/>
                ස්ද් ද්ස් ස්ද් ත්‍ය්‍ර් ත්‍යි යුඉඔයුඉඔ<br/>
            </span>
        </td>
        <td colspan="3"><?= $batch->examination_center ?></td>
    </tr>
    <tr>
        <td colspan="4">
            Paste the bank voucher here<br/>
            <span style="font-family:aaaaa">
                அத² கோ² ஸுதி³ன்னோ கலந்த³புத்தோ<br/>
                කොමන්ස් ඇට්‍රිබ්යුශන්/ශෙයා-අලයික් වරපතට යටත්ව<br/>		
                அத² கோ² ஸுதி³ன்னோ கலந்த³புத்தோ அசிரவுட்டி²தாய பரிஸாய யேன ப⁴க³வா தேனுபஸங்கமி<br/>
                அத² கோ² ஸுதி³ன்னோ கலந்த³புத்தோ<br/>
            </span>
        </td>
    </tr>
</tbody>
</table>

<?php
if (isset($id)) {
    echo Html::a('Download', ['pdf', 'id' => $id]);
}
?>
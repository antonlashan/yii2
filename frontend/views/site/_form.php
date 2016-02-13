<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use common\models\UserDetail;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $userDetail common\models\UserDetail */
/* @var $batch common\models\Batch */
/* @var $form yii\widgets\ActiveForm */

$inputName_paymentMethod = Html::getInputName($userDetail, 'payment_mathod');
$this->registerJs(
        "
            function show_hide_bankdiv() {
                if($(\"[name='$inputName_paymentMethod']:checked\").val() == " . UserDetail::PAYMENT_M_BANK . ") {
                    $('#bank').show();
                } else {
                    $('#bank').hide()
                }
            }
            $('document').ready(function(){
                show_hide_bankdiv();
            });
            $(\"[name='$inputName_paymentMethod']\").click(function(){
                show_hide_bankdiv();
            });
        "
);
?>

<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-md-12">
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Tennakon Mudiyanselage Thanuja Nayana Malmi Kumari Tennakon'])->label('Name of the Applicant') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'initials')->textInput(['maxlength' => true, 'placeholder' => 'Ex: T M T N M K Tennakoon']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'gender')->dropDownList($userDetail->getGenderLabels(), ['prompt' => '- select gender -']) ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($userDetail, 'dob')->widget(
                    DatePicker::className(), [
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'startView' => 'decade',
                    'startDate' => date("Y-m-d", $batch->getRestrictedTimestamp()),
                ]
            ])
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'address')->textarea() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'exam_center_id')->dropDownList($examCenters, ['prompt' => '- select center -']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'telephone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('e-mail') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($userDetail, 'medium')->dropDownList($userDetail->getMediumLabels(), ['prompt' => '- select medium -']) ?>
        </div>
        <div class="col-md-6">
            <?=
            $form->field($userDetail, 'payment_mathod')->radioList($userDetail->getPaymentMethodLabels(), [
                'item' => function($index, $label, $name, $checked, $value) {
                    $disabled = '';
//                    if ($value == UserDetail::PAYMENT_M_ONLINE)
//                        $disabled = 'disabled';

                    if ($checked)
                        $checked = 'checked=1';
                    else
                        $checked = '';
                    $return = '<label><input type="radio" ' . $disabled . ' ' . $checked . ' name="' . $name . '" value="' . $value . '"> ' . $label . '</label>';
                    return $return;
                }
            ])
            ?>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($userDetail, 'payment_date')->widget(
                            DatePicker::className(), [
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'startView' => 'decade',
                        ]
                    ])
                    ?>
                </div>
                <div class="col-md-6" id="bank">
                    <?= $form->field($userDetail, 'bank_branch')->textInput(['maxlength' => true]) ?>
                </div>
            </div>            
        </div>
        <div class="col-md-12">
            <p class="help-block">If you have a "Rankekulu" or "14+plus" account at the Bank of Ceylon, Enter the account number and the BOC Branch.</p>
            <div class="row">
                
                <div class="col-md-6">
                    <?= $form->field($userDetail, 'boc_account_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($userDetail, 'boc_branch')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($userDetail, 'confirm')->checkbox() ?>
        </div>
    </div>
    <div class="clearfix form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
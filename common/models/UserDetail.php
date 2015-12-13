<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%user_detail}}".
 *
 * @property integer $user_id
 * @property string $initials
 * @property string $reg_no
 * @property integer $gender
 * @property string $dob
 * @property string $exam_center_id
 * @property string $telephone
 * @property integer $medium
 * @property string $academic_year
 * @property integer $payment_mathod
 * @property string $payment_date
 * @property string $bank_branch
 *
 * @property User $user
 * @property Batch $batch
 * @property BatchExamCenters $examCenter
 */
class UserDetail extends \yii\db\ActiveRecord {

    //gender
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    //medium
    const MEDIUM_SINHALA = 1;
    const MEDIUM_TAMIL = 2;
    const MEDIUM_ENGLISH = 3;
    //
    const SCENARIO_REGISTRATION = 'registration';
    //payment methods
    const PAYMENT_M_ONLINE = 1;
    const PAYMENT_M_BANK = 2;

    private $_batch = null;
    public $confirm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'medium', 'exam_center_id', 'payment_mathod'], 'integer'],
            [['initials', 'gender', 'dob', 'telephone', 'medium', 'exam_center_id', 'payment_mathod'], 'required'],
            [['academic_year', 'payment_date'], 'safe'],
            [['initials'], 'string', 'max' => 150],
            [['reg_no', 'bank_branch'], 'string', 'max' => 50],
            [['telephone'], 'string', 'max' => 20],
            [['confirm'], 'required', 'on' => self::SCENARIO_REGISTRATION, 'requiredValue' => 1, 'message' => 'Please Confirm'],
            ['dob', 'daterange_validation'],
            [['payment_date', 'bank_branch'], 'required', 'when' => function ($model) {
            return $model->payment_mathod == self::PAYMENT_M_BANK;
        }, 'whenClient' => "function (attribute, value) {
                    
                        return $(\"[name='" . Html::getInputName($this, 'payment_mathod') . "']:checked\").val() == '" . self::PAYMENT_M_BANK . "';
                    }"],
        ];
    }

    public function daterange_validation($attribute, $params)
    {
        if (($batch = Batch::getCurrentBatch()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($batch->getRestrictedTimestamp() > strtotime($this->$attribute))
            $this->addError($attribute, 'Custom Validation Error');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'initials' => 'Name with Initials',
            'reg_no' => 'Registration Number',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'exam_center_id' => 'Exam Center',
            'telephone' => 'Contact Telephone',
            'medium' => 'Medium',
            'academic_year' => 'Academic Year',
            'confirm' => 'Please Confirm',
            'payment_mathod' => 'Payment Mathod',
            'payment_date' => 'Payment Date',
            'bank_branch' => 'Bank Branch',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGenderLabels()
    {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
    }

    public function getGenderLabel()
    {
        return $this->getGenderLabels()[$this->gender];
    }

    public function getMediumLabels()
    {
        return [
            self::MEDIUM_SINHALA => 'Sinhala',
            self::MEDIUM_TAMIL => 'Tamil',
            self::MEDIUM_ENGLISH => 'English',
        ];
    }

    public function getMediumLabel()
    {
        return $this->getMediumLabels()[$this->medium];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->_batch = Batch::findOne(['status' => Batch::STATUS_ACTIVE]);
            $this->reg_no = $this->_batch->name . '-' . str_pad($this->_batch->counter, 5, 0, STR_PAD_LEFT);
            $this->academic_year = $this->_batch->year;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->_batch->updateCounters(['counter' => 1]);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(Batch::className(), ['year' => 'academic_year']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamCenter()
    {
        return $this->hasOne(BatchExamCenters::className(), ['id' => 'exam_center_id']);
    }

    public function getPaymentMethodLabels()
    {
        return [
            self::PAYMENT_M_ONLINE => 'Online',
            self::PAYMENT_M_BANK => 'Paid to the bank',
        ];
    }

    public function getPaymentMethodLabel()
    {
        $labels = $this->getPaymentMethodLabels();
        return isset($labels[$this->payment_mathod]) ? $labels[$this->payment_mathod] : null;
    }

}

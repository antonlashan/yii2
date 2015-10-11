<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_detail}}".
 *
 * @property integer $user_id
 * @property string $initials
 * @property string $reg_no
 * @property integer $gender
 * @property string $dob
 * @property string $college_and_address
 * @property string $telephone
 * @property integer $medium
 * @property string $academic_year
 *
 * @property User $user
 * @property Batch $batch
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

    private $_batch = null;
    public $confirm;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'gender', 'medium'], 'integer'],
            [['initials', 'gender', 'dob', 'college_and_address', 'telephone', 'medium'], 'required'],
            [['dob', 'academic_year'], 'safe'],
            [['initials'], 'string', 'max' => 150],
            [['reg_no'], 'string', 'max' => 50],
            [['college_and_address'], 'string', 'max' => 250],
            [['telephone'], 'string', 'max' => 20],
            [['confirm'], 'required', 'on' => self::SCENARIO_REGISTRATION, 'requiredValue' => 1, 'message' => 'Please Confirm'],
//			[['confirm'], 'required', 'requiredValue' => 1, 'message' => 'Please Confirm'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'initials' => 'Name with Initials',
            'reg_no' => 'Registration Number',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'college_and_address' => 'College & Addresss',
            'telephone' => 'Contact Telephone',
            'medium' => 'Medium',
            'academic_year' => 'Academic Year',
            'confirm' => 'Please Confirm',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGenderLabels() {
        return [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
    }

    public function getGenderLabel() {
        return $this->getGenderLabels()[$this->gender];
    }

    public function getMediumLabels() {
        return [
            self::MEDIUM_SINHALA => 'Sinhala',
            self::MEDIUM_TAMIL => 'Tamil',
            self::MEDIUM_ENGLISH => 'English',
        ];
    }

    public function getMediumLabel() {
        return $this->getMediumLabels()[$this->medium];
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->_batch = Batch::findOne(['status' => Batch::STATUS_ACTIVE]);
            $this->reg_no = $this->_batch->name . '-' . str_pad($this->_batch->counter, 5, 0, STR_PAD_LEFT);
            $this->academic_year = $this->_batch->year;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        if ($insert)
            $this->_batch->updateCounters(['counter' => 1]);

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatch() {
        return $this->hasOne(Batch::className(), ['year' => 'academic_year']);
    }

}

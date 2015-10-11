<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%batch}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $year
 * @property string $age_as_at
 * @property string $date_of_examination
 * @property string $time
 * @property string $examination_center
 * @property integer $counter
 * @property integer $status
 * 
 * @property UserDetail[] $userDetails
 */
class Batch extends \yii\db\ActiveRecord {

    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%batch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'year', 'date_of_examination', 'time', 'examination_center'], 'required'],
            [['year', 'age_as_at', 'date_of_examination'], 'safe'],
            [['counter', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['time'], 'string', 'max' => 20],
            [['examination_center'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Batch Name',
            'year' => 'Academic Year',
            'age_as_at' => 'Age as at',
            'date_of_examination' => 'Date of Examination',
            'time' => 'Time',
            'examination_center' => 'Examination Center And number',
            'counter' => 'Counter',
            'status' => 'Status',
        ];
    }

    public function getStatusLabels() {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getStatusLabel() {
        return $this->getStatusLabels()[$this->status];
    }

    public static function getCurrentBatch() {
        return self::findOne(['status' => self::STATUS_ACTIVE]);
    }

    public function getAgeAsAt($date) {
        $datetime1 = date_create($this->age_as_at);
        $datetime2 = date_create($date);
        $interval = date_diff($datetime1, $datetime2);

        return $interval->format('%y Years %m Months %d Days');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDetails() {
        return $this->hasMany(UserDetail::className(), ['academic_year' => 'year']);
    }

}

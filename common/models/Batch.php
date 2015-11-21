<?php

namespace common\models;

use Yii;
use common\components\Helper;

/**
 * This is the model class for table "{{%batch}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $year
 * @property string $age_as_at
 * @property string $date_of_examination
 * @property string $time
 * @property integer $counter
 * @property integer $status
 * @property integer $restricted_age
 * 
 * @property UserDetail[] $userDetails
 * @property BatchExamCenters[] $batchExamCenters
 */
class Batch extends \yii\db\ActiveRecord {

    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%batch}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'year', 'date_of_examination', 'time'], 'required'],
            [['year', 'age_as_at', 'date_of_examination'], 'safe'],
            [['counter', 'status', 'restricted_age'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['time'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Batch Name',
            'year' => 'Academic Year',
            'age_as_at' => 'Age as at',
            'date_of_examination' => 'Date of Examination',
            'time' => 'Time',
            'counter' => 'Counter',
            'status' => 'Status',
            'restricted_age' => 'Restricted Age'
        ];
    }

    public function getStatusLabels()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public function getStatusLabel()
    {
        return $this->getStatusLabels()[$this->status];
    }

    public static function getCurrentBatch()
    {
        return self::findOne(['status' => self::STATUS_ACTIVE]);
    }

    public function getAgeAsAt($date)
    {
        $interval = Helper::getDaysBetweenDates($this->age_as_at, $date);

        return $interval->format('%y Years %m Months %d Days');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDetails()
    {
        return $this->hasMany(UserDetail::className(), ['academic_year' => 'year']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatchExamCenters()
    {
        return $this->hasMany(BatchExamCenters::className(), ['batch_id' => 'id']);
    }

    public function getRestrictedTimestamp()
    {
        return strtotime("-{$this->restricted_age} year", strtotime($this->age_as_at));
    }

}

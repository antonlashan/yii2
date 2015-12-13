<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%batch_exam_centers}}".
 *
 * @property integer $id
 * @property integer $batch_id
 * @property string $name
 *
 * @property Batch $batch
 */
class BatchExamCenters extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%batch_exam_centers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['batch_id', 'name'], 'required'],
            [['batch_id'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_id' => 'Batch ID',
            'name' => 'Center',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(Batch::className(), ['id' => 'batch_id']);
    }

    public static function getCentersArrByBatch($batchId)
    {
        return self::find()->where(['batch_id' => $batchId])->asArray()->all();
    }

}

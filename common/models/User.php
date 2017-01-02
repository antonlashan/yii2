<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $title
 * @property string $full_name
 * @property integer $is_admin
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserDetail $userDetail
 */
class User extends ActiveRecord implements IdentityInterface {

    //status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    //title
    const TITLE_MR = 1;
    const TITLE_MRS = 2;
    const TITLE_MS = 3;
    const TITLE_DR = 4;
    const TITLE_PROF = 5;
    //is admin
    const IS_ADMIN_YES = 1;
    const IS_ADMIN_NO = 0;
    const SCENARIO_REGISTRATION = 'registration';
    
    public $dob;
    public $college;
    public $academic_year;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['full_name'], 'required'],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['email', 'email'],
            [['full_name'], 'validateUserReg', 'on' => static::SCENARIO_REGISTRATION],
        ];
    }

    /**
     * Validate user registration by full name, dob, college and batch
     */
    public function validateUserReg()
    {
        $user = static::findOne(['full_name' => $this->full_name]);
        if ($user) {
            
            $userDetail = UserDetail::findOne(['user_id' => $user->id, 'dob' => $this->dob, 'college' => $this->college, 'academic_year' => $this->academic_year]);
            
            if ($userDetail) {
                $this->addError('full_name', 'Already applied.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getTitleLabels()
    {
        return [
            self::TITLE_MR => 'Mr',
            self::TITLE_MRS => 'Mrs',
            self::TITLE_MS => 'Ms',
            self::TITLE_DR => 'Dr',
            self::TITLE_PROF => 'Prof',
        ];
    }

    public function getTitleLabel()
    {
        return isset($this->getTitleLabels()[$this->title]) ? $this->getTitleLabels()[$this->title] : '';
    }

    public function getIsAdminLabels()
    {
        return [
            self::IS_ADMIN_YES => 'Yes',
            self::IS_ADMIN_NO => 'No',
        ];
    }

    public function getIsAdminLabel()
    {
        return $this->getIsAdminLabels()[$this->is_admin];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserDetail()
    {
        return $this->hasOne(UserDetail::className(), ['user_id' => 'id']);
    }

}

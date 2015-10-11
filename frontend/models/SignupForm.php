<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model {

	public $email;
	public $password;
	public $full_name;
	public $title;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['email', 'filter', 'filter' => 'trim'],
			[['email', 'full_name', 'title'], 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
			['password', 'required'],
			['password', 'string', 'min' => 6],
		];
	}
	
	public function attributeLabels()
	{
		return [
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return User|null the saved model or null if saving fails
	 */
	public function signup()
	{
		if ($this->validate()) {
			$user = new User();
			$user->email = $this->email;
			$user->full_name = $this->full_name;
			$user->title = $this->title;
			$user->status = User::STATUS_INACTIVE;
			$user->is_admin = User::IS_ADMIN_NO;
			$user->setPassword($this->password);
			$user->generateAuthKey();
			if ($user->save()) {
				\Yii::$app->mailer->compose(['html' => 'signupRequest-html', 'text' => 'signupRequest-text'], ['user' => $user])
					->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
					->setTo(\Yii::$app->params['adminEmail'])
					->setSubject('New Signup for ' . \Yii::$app->name)
					->send();

				return $user;
			}
		}

		return null;
	}

}

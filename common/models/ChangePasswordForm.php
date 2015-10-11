<?php

namespace common\models;

use common\models\User;
use yii\web\NotFoundHttpException;
use yii\base\Model;
use Yii;

/**
 * Password change form
 */
class ChangePasswordForm extends Model {

	public $password;

	/**
	 * @var \common\models\User
	 */
	private $_user;

	/**
	 * Creates a form model given a token.
	 *
	 * @param  string                          $userId
	 * @param  array                           $config name-value pairs that will be used to initialize the object properties
	 * @throws \yii\base\InvalidParamException if token is empty or not valid
	 */
	public function __construct($userId, $config = [])
	{
		if (empty($userId)) {
			throw new NotFoundHttpException('UserId cannot be blank.');
		}
		$this->_user = User::findOne($userId);
		if (!$this->_user) {
			throw new NotFoundHttpException('Wrong');
		}
		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['password', 'required'],
			['password', 'string', 'min' => 6],
		];
	}

	/**
	 * Change password.
	 *
	 * @return boolean if password was reset.
	 */
	public function changePassword()
	{
		$user = $this->_user;
		$user->setPassword($this->password);

		return $user->save(false);
	}

}

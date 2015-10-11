<?php

namespace frontend\controllers;

use Yii;
use common\models\Batch;
use common\models\User;
use common\models\UserDetail;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

/**
 * Site controller
 */
class SiteController extends Controller {

	public $defaultAction = 'create';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup'],
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Creates a new User model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new User();
		$userDetail = new UserDetail(['scenario' => UserDetail::SCENARIO_REGISTRATION]);

		if (Yii::$app->request->post() && $model->load(Yii::$app->request->post()) && $userDetail->load(Yii::$app->request->post())) {

			$model->is_admin = User::IS_ADMIN_NO;
			$model->status = User::STATUS_INACTIVE;

			if ($model->save()) {

				$userDetail->user_id = $model->id;

				if ($userDetail->save()) {
					$id = urlencode(base64_encode($model->id));
					return $this->redirect(['view', 'id' => $id]);
				}
			}
		}

		return $this->render('create-student', [
				'model' => $model,
				'userDetail' => $userDetail,
		]);
	}

	public function actionView($id)
	{
		$decodedId = base64_decode(urldecode($id));

		if (($user = User::findOne($decodedId)) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if (($batch = Batch::getCurrentBatch()) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		return $this->render('view', ['user' => $user, 'batch' => $batch, 'id' => $id]);
	}

	public function actionPdf($id)
	{
		$id = base64_decode(urldecode($id));

		if (($user = User::findOne($id)) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		if (($batch = Batch::getCurrentBatch()) === null) {
			throw new NotFoundHttpException('The requested page does not exist.');
		}

		$content = $this->renderPartial('view', ['user' => $user, 'batch' => $batch]);

		// setup kartik\mpdf\Pdf component
		$pdf = new Pdf([
			// set to use core fonts only
//			'mode' => Pdf::MODE_UTF8, 
			// A4 paper format
			'format' => Pdf::FORMAT_A4,
			// portrait orientation
			'orientation' => Pdf::ORIENT_PORTRAIT,
			// stream to browser inline
			'destination' => Pdf::DEST_DOWNLOAD,
			// your html content input
			'content' => $content,
			// format content from your own css file if needed or use the
			// enhanced bootstrap css built by Krajee for mPDF formatting 
//			'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
			'cssFile' => '',
//			// any css to be embedded if required
			'cssInline' => 'table {border-collapse: collapse;} table, td {border: 1px solid black; font-size: 14px;font-family: dejavuserif;}',
//			// set mPDF properties on the fly
//			'options' => ['charset_in' => 'windows-1252', ' allow_charset_conversion' => true],
//			// call mPDF methods on the fly
//			'methods' => [
//				'SetHeader' => ['Krajee Report Header'],
//				'SetFooter' => ['{PAGENO}'],
//			]
		]);

		// return the pdf output as per the destination setting
		return $pdf->render();
	}

}

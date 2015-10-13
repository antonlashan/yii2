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
    public function behaviors() {
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
    public function actions() {
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
    public function actionCreate() {
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

    public function actionView($id) {
        $decodedId = base64_decode(urldecode($id));

        if (($user = User::findOne($decodedId)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (($batch = Batch::getCurrentBatch()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', ['user' => $user, 'batch' => $batch, 'id' => $id, 'pdf' => false]);
    }

    public function actionPdf($id) {
        $id = base64_decode(urldecode($id));

        if (($user = User::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if (($batch = Batch::getCurrentBatch()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $content = $this->renderPartial('view', ['user' => $user, 'batch' => $batch, 'pdf' => true]);

        define('DOMPDF_ENABLE_AUTOLOAD', false);
        require_once Yii::getAlias('@vendor') . '/dompdf/dompdf/dompdf_config.inc.php';
        $dompdf = new \DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream("sample.pdf");
    }

}

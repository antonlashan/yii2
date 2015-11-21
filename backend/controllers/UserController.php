<?php

namespace backend\controllers;

use Yii;
use backend\models\StudentSearch;
use backend\models\UserSearch;
use common\models\Batch;
use common\models\BatchExamCenters;
use common\models\ChangePasswordForm;
use common\models\User;
use common\models\UserDetail;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);

        $userDetail = $user->userDetail;
        if (!$userDetail)
            $userDetail = new UserDetail();

        $userDetail->qualifications = ArrayHelper::map(UserQualifications::findAll(['user_id' => $user->id]), 'qualification_id', 'qualification_id');
        $userDetail->specializations = ArrayHelper::map(UserSpecializations::findAll(['user_id' => $user->id]), 'specialization_id', 'specialization_id');

        if ($userDetail->isNewRecord) {
            $userDetail->visibility_email = UserDetail::VISIBILITY_EMAIL_YES;
            $userDetail->visibility_official_address = UserDetail::VISIBILITY_OFFICIAL_ADDRESS_YES;
            $userDetail->visibility_permanent_address = UserDetail::VISIBILITY_PERMANENT_ADDRESS_YES;
            $userDetail->visibility_phone_office = UserDetail::VISIBILITY_PHONE_OFFICE_YES;
            $userDetail->visibility_phone_residence = UserDetail::VISIBILITY_PHONE_RESIDENCE_YES;
            $userDetail->visibility_phone_mobile = UserDetail::VISIBILITY_PHONE_MOBILE_YES;
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            if ($userDetail->load(Yii::$app->request->post())) {
                $userDetail->user_id = $user->id;
                if ($userDetail->save()) {

                    //delete insert qualifications
                    UserQualifications::deleteAll(['user_id' => $user->id]);
                    if (!empty($userDetail->qualifications)) {

                        foreach ($userDetail->qualifications as $qualificationId) {
                            $uQualifications = new UserQualifications();
                            $uQualifications->qualification_id = $qualificationId;
                            $uQualifications->user_id = $user->id;
                            $uQualifications->save();
                        }
                    }

                    //delete insert specializations
                    UserSpecializations::deleteAll(['user_id' => $user->id]);
                    if (!empty($userDetail->specializations)) {

                        foreach ($userDetail->specializations as $specializationId) {
                            $uSpecializations = new UserSpecializations();
                            $uSpecializations->specialization_id = $specializationId;
                            $uSpecializations->user_id = $user->id;
                            $uSpecializations->save();
                        }
                    }
                    return $this->redirect(['view', 'id' => $user->id]);
                }
            }
        }

        $memberCategoryList = ArrayHelper::map(UserCategory::findAll(['status' => UserCategory::STATUS_ACTIVE]), 'id', 'name');
        $qualificationList = ArrayHelper::map(Qualification::findAll(['status' => Qualification::STATUS_ACTIVE]), 'id', 'name');
        $specializationList = ArrayHelper::map(Specialization::findAll(['status' => Specialization::STATUS_ACTIVE]), 'id', 'name');

        return $this->render('update', [
                    'user' => $user,
                    'userDetail' => $userDetail,
                    'memberCategoryList' => $memberCategoryList,
                    'qualificationList' => $qualificationList,
                    'specializationList' => $specializationList,
        ]);
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->status == User::STATUS_ACTIVE)
                \Yii::$app->mailer->compose(['html' => 'activateMember-html', 'text' => 'activateMember-text'], ['user' => $model])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                        ->setTo($model->email)
                        ->setSubject('Profile activated')
                        ->send();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update_status', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUserdetailModel($id)
    {
        if (($model = UserDetail::find()
                        ->joinWith('user', true, 'INNER JOIN')
                        ->where(['user_id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionChangePassword($id)
    {
        $model = new ChangePasswordForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->redirect(['index']);
        }

        return $this->render('change_password', [
                    'model' => $model,
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionStudents()
    {
        $currBatch = Batch::getCurrentBatch();

        $searchModel = new StudentSearch();
        $searchModel->academic_year = $currBatch->year;

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('students', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewStudent($id)
    {
        return $this->render('view_student', [
                    'model' => $this->findUserdetailModel($id),
        ]);
    }

    public function actionUpdateStudent($id)
    {

        $userDetail = $this->findUserdetailModel($id);
        $user = $userDetail->user;

        if (Yii::$app->request->post() && $user->load(Yii::$app->request->post()) && $userDetail->load(Yii::$app->request->post())) {

            if ($user->save()) {

                if ($userDetail->save()) {
                    return $this->redirect(['view-student', 'id' => $userDetail->user_id]);
                }
            }
        }

        if (($batch = Batch::getCurrentBatch()) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $examCenters = ArrayHelper::map(BatchExamCenters::find()->where(['batch_id' => $batch->id])->asArray()->all(), 'id', 'name');

        return $this->render('update_student', [
                    'user' => $user,
                    'userDetail' => $userDetail,
                    'examCenters' => $examCenters,
        ]);
    }

    public function actionDeleteStudent($id)
    {
        $this->findModel($id)->delete();
        UserDetail::deleteAll(['user_id' => $id]);

        return $this->redirect(['students']);
    }

    public function actionExportStudentsCsv($year)
    {

        $batch = Batch::find()
                        ->joinWith('userDetails', true, 'INNER JOIN')
                        ->where(['academic_year' => $year])->one();

        if ($batch == null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $userDetail = new UserDetail();

        // send response headers to the browser
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment;filename=' . $batch->name . '.csv');
        $fp = fopen('php://output', 'w');

        fputcsv($fp, [
            $userDetail->getAttributeLabel('reg_no'),
//            'Full Name',
            $userDetail->getAttributeLabel('initials'),
            'Email',
            $userDetail->getAttributeLabel('gender'),
            $userDetail->getAttributeLabel('dob'),
            $userDetail->getAttributeLabel('college_and_address'),
            $userDetail->getAttributeLabel('telephone'),
            $userDetail->getAttributeLabel('medium'),
            $userDetail->getAttributeLabel('payment_date'),
            $userDetail->getAttributeLabel('bank_branch'),
        ]);
        foreach ($batch->userDetails as $detail) {
            fputcsv($fp, [
                "{$detail->reg_no}",
//                "{$detail->user->full_name}",
                "{$detail->initials}",
                "{$detail->user->email}",
                "{$detail->getGenderLabel()}",
                "{$detail->dob}",
                "{$detail->telephone}",
                "{$detail->getMediumLabel()}",
                "{$batch->name}",
                "{$detail->payment_date}",
                "{$detail->bank_branch}",
            ]);
        }

        fclose($fp);
    }

}

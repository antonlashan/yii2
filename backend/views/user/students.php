<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search_students', ['model' => $searchModel]); ?>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'reg_no',
            'initials',
            [
                'attribute' => 'exam_center_id',
                'filter' => Html::activeDropDownList($searchModel, 'exam_center_id', ArrayHelper::map($examCenters, 'id', 'name'), ['class' => 'form-control', 'prompt' => 'Select Center']),
                'value' => function($data) {
            return !empty($data->examCenter) ? $data->examCenter->name : null;
        }
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getGenderLabel();
                }
            ],
            'telephone',
            [
                'attribute' => 'payment_mathod',
                'value' => function($data) {
                    return $data->getPaymentMethodLabel();
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    //view button
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['view-student', 'id' => $model->user_id]), [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                            //update button
                            'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Url::to(['update-student', 'id' => $model->user_id]), [
                                    'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                            //delete button
                            'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', Url::to(['delete-student', 'id' => $model->user_id]), [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'data-confirm' => Yii::t('yii', 'Are you sure to delete this item?'),
                                    'data-method' => 'post',
                        ]);
                    },
                        ],
                    ],
                ],
            ]);
            ?>

            <?= Html::a('Export to CSV', ['export-students-csv', 'year' => $searchModel->academic_year, 'cid' => $searchModel->exam_center_id], ['class' => 'btn btn-danger']) ?>

</div>
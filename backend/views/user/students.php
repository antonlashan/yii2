<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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
            'initials',
            'user.full_name',
            'reg_no',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getGenderLabel();
                }
            ],
            'telephone',
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
    
    <?= Html::a('Export to CSV', ['export-students-csv', 'year' => $searchModel->academic_year], ['class' => 'btn btn-danger']) ?>

</div>
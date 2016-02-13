<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'value' => function($data) {
                    return $data->getTitleLabel();
                }
            ],
            'full_name',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function($data) {
                    return $data->getStatusLabel();
                }
            ],
            // 'created_at',
            // 'updated_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete} {change-pwd}',
                'buttons' => [
                    //activate button
                    'activate' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', yii\helpers\Url::to(['update-status', 'id' => $model->id]), [
                                    'title' => Yii::t('app', 'Activate/Deactivate'),
                        ]);
                    },
                    //change-pwd button
                    'change-pwd' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-wrench"></span>', yii\helpers\Url::to(['change-password', 'id' => $model->id]), [
                                    'title' => Yii::t('app', 'Change Password'),
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>

</div>

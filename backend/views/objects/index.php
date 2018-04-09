<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjectsSearcjh */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '对象';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Objects', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'en_name',
            'create_date',
            // 'update_date',
            'status',

            [
                'attribute' => 'operations',
                'value' => function($model){
                    return Json::encode($model->operations);
                }
            ],
            'order',
            'list_show_fields',
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view} {update} {delete} {obj_fields} {createTable} {createModel}',
                'buttons' => [
                    'obj_fields'=>function($url, $model, $key){
                        return Html::a('字段设置',['/object-fields','object_id'=>$model->id],[
                                'class'=>'btn btn-primary btn-sm' ]);
                    },
                    'createTable'=>function($url, $model, $key){
                        return Html::a('生成表',['db','id'=>$model->id],[
                                'class'=>'btn btn-primary btn-sm','target'=>'_blank']);
                    },
                    'createModel'=>function($url, $model, $key){
                        return Html::a('生成模型',['cm','id'=>$model->id],[
                                'class'=>'btn btn-primary btn-sm','target'=>'_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

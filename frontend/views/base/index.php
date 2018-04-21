<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Json;
use common\models\QmylWidgets;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bases';
$this->params['breadcrumbs'][] = $this->title;


$model = new $dataProvider->query->modelClass();
$tableName = Yii::$app->request->queryParams['table'];
$atrs = $model->attributes();
$columns = [['class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, $model, $key, $index)use($tableName) {
                $params = [];
                    switch($action)
                    {
                        case 'view':
                            return ['view','table'=>$tableName,'id'=>$key];
                        break;
                        case 'update':
                            return ['update','table'=>$tableName,'id'=>$key];
                        break;
                        case 'delete':
                            return ['delete','table'=>$tableName,'id'=>$key];
                        break;

                    }

                },
            // 'header'=>'操作',
            // 'template'=>'{view} {update} {delete}',
            // 'buttons' => [
            //     'view'=>function($url, $model, $key)use($tableName){
            //         return Html::a('详情',['view','table'=>$tableName,'id'=>$key],[
            //                 'class'=>'btn btn-info btn-sm','data-toggle'=>"modal",'data-target'=>"#myModal"
            //         ]);
            //     },
            //     'update'=>function($url, $model, $key)use($tableName){
            //         return Html::a('更新',['update','table'=>$tableName,'id'=>$key],[
            //                 'class'=>'btn btn-primary btn-sm','data-toggle'=>"modal",'data-target'=>"#myModal"
            //         ]);
            //     },
            // ],



             ],] ;


$atrs = QmylWidgets::createIndexColumns($model);
$columns = array_merge($atrs,$columns);
 // var_dump($atrs); die;

?>
<div class="base-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Base', ['create','table'=>Yii::$app->request->queryParams['table']], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>
</div>

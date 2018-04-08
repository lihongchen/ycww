<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DictionarySearcjh */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dictionaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dictionary-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dictionary', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'create_date',
            'update_date',
            'status',
            'name',
            'interface',

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view} {update} {delete} {key_value}',
                'buttons' => [
                    'key_value'=>function($url, $model, $key){
                        return Html::a('字典选项',['/dictionary-value','dictionary_id'=>$model->id],[
                                'class'=>'btn btn-primary btn-sm' ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>

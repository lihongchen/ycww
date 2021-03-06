<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ObjectFieldsSearcjh */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Object Fields';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-fields-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Object Fields', ['create','object_id'=>Yii::$app->request->queryParams['object_id']], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'en_name',
            'db_type',
            'create_date',
            'update_date',
            'status',
            // 'rules:ntext',
            'object_id',
            'field_group1',
            'field_group2',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

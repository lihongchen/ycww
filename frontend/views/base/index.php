<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bases';
$this->params['breadcrumbs'][] = $this->title;


$model = $dataProvider->query->modelClass;
$atrs = (new $model())->attributes();
$columns = [ ['class' => 'yii\grid\ActionColumn'], ] ;
$columns = array_merge($atrs,$columns);
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

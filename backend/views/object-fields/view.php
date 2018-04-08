<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $model backend\models\ObjectFields */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Object Fields', 'url' => ['index','object_id'=>$model->object_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-fields-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'create_date',
            'update_date',
            'status',
            'name',
            'db_type',
            [
                'attribute' => 'rules',
                'value' => function($model){
                    return Json::encode($model->rules);
                }
            ],
            'object_id',
            'dictionary_id',
            [
                'attribute' => 'qmbehaviors',
                'value' => function($model){
                    return Json::encode($model->qmbehaviors);
                }
            ],
        ],
    ]) ?>

</div>

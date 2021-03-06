<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $model backend\models\Rules */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rules-view">

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
            'rule_group',
            [
                'attribute' => 'refids',
                'value' => function($model){
                    return Json::encode($model->refids);
                }
            ],
            'en_name',
            'rule_value',
            'self_use',
        ],
    ]) ?>

</div>

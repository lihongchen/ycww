<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ObjectFields */

$this->title = 'Update Object Fields: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Object Fields', 'url' => ['index','object_id'=>$model->object_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="object-fields-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ObjectFields */

$this->title = 'Create Object Fields';
$this->params['breadcrumbs'][] = ['label' => 'Object Fields', 'url' => ['index','object_id'=>$model->object_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-fields-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

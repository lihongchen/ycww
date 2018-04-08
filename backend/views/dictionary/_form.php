<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
/* @var $this yii\web\View */
/* @var $model backend\models\Dictionary */
/* @var $form yii\widgets\ActiveForm */
if(empty($model->status)){
   $model->status = 1; 
}
?>

<div class="dictionary-form">

    <?php $form = ActiveForm::begin(); ?>

<!--     <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?> -->


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status')) ?>

    


    <?= $form->field($model, 'interface')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

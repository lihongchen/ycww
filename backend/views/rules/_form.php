<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
/* @var $this yii\web\View */
/* @var $model backend\models\Rules */
/* @var $form yii\widgets\ActiveForm */
if(empty($model->status)){
   $model->status = 1; 
}
?>

<div class="rules-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rule_value')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'refids')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status')) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

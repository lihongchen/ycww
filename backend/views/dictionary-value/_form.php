<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
if(empty($model->status)){
   $model->status = 1; 
}
/* @var $this yii\web\View */
/* @var $model backend\models\DictionaryValue */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dictionary-value-form">

    <?php $form = ActiveForm::begin(); ?>


 
    <?= $form->field($model, 'key')->textInput(['maxlength' => true,'autofocus'=>'autofocus']) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status')) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
/* @var $this yii\web\View */
/* @var $model backend\models\ObjectFields */
/* @var $form yii\widgets\ActiveForm */
if(empty($model->status)){
   $model->status = 1; 
}
if(empty($model->db_type)){
   $model->db_type = array_keys(DataDict::getDict('db_type'))[0]; 
}
?>

<div class="object-fields-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'db_type')->radioList(DataDict::getDict('db_type')) ?>
    <?= $form->field($model, 'qmbehaviors')->checkboxList(DataDict::getDict('qmbehaviors'))?>
    <?= $form->field($model, 'rules')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status'))?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

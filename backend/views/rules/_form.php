<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
use backend\models\Rules;
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
    <?= $form->field($model, 'rule_group')->radioList(DataDict::getDict('rule_group')) ?>
    <?= $form->field($model, 'en_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'rule_value')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'refids')->checkboxList(Rules::getRules($model->id)) ?>

    <?= $form->field($model, 'self_use')->radioList(DataDict::getDict('self_use')) ?>
    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status')) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

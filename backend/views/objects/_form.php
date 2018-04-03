<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DataDict;
/* @var $this yii\web\View */
/* @var $model backend\models\Objects */
/* @var $form yii\widgets\ActiveForm */
if(empty($model->status)){
   $model->status = 1; 
}
?>

<div class="objects-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?> -->

    

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->radioList($model->getParentCode($model->id)) ?>

    <?= $form->field($model, 'operations')->checkboxList(DataDict::getDict('operations')) ?>

    <?= $form->field($model, 'list_show_fields')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->radioList(DataDict::getDict('status'))?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

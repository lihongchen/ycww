<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Base */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-form">

    <?php $form = ActiveForm::begin(); ?>



<?php  


$qmylRules = unserialize($model->qmylRules());
 var_dump($qmylRules);

?>




    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

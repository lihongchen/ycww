<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\QmylWidgets;
/* @var $this yii\web\View */
/* @var $model frontend\models\Base */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-form">

    <?php $form = ActiveForm::begin(); ?>



<?php  
$qmylWidgets = new QmylWidgets();
echo $qmylWidgets->createForm($form,$model);
?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

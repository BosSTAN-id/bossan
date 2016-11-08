<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaSPHSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sph-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <?php echo $form->field($model, 'No_SPH')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'No SPH')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaRPHSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rph-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'No_RPH')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'No RPH')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
